<?php
/**
 * Standards-compliant QR Code encoder (ISO/IEC 18004), pure PHP, no network access.
 *
 * Byte mode, error correction level L or M, versions 1 to 10 (up to 213 bytes at level M... see
 * capacity below). Output is a module matrix and an SVG. Verified by decoding generated codes
 * with an independent QR reader (jsQR); see the test notes in CLAUDE_TO_ANTIGRAVITY_HANDOFF.md.
 *
 * Algorithm follows the public ISO 18004 procedure: data bits -> Reed-Solomon blocks over
 * GF(256) (0x11D) -> interleave -> place in the zig-zag -> choose the lowest-penalty mask ->
 * write format and version information.
 *
 * @package Cr8v_Event_Ticketing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Cr8v_Qr {

	const MAX_VERSION = 10;

	/** Error correction codewords per block, index = version (0 unused). */
	private static $ecc_per_block = array(
		'L' => array( -1, 7, 10, 15, 20, 26, 18, 20, 24, 30, 18 ),
		'M' => array( -1, 10, 16, 26, 18, 24, 16, 18, 22, 22, 26 ),
	);

	/** Number of error correction blocks, index = version (0 unused). */
	private static $num_blocks = array(
		'L' => array( -1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 4 ),
		'M' => array( -1, 1, 1, 1, 2, 2, 4, 4, 4, 5, 5 ),
	);

	private static $format_bits = array( 'L' => 1, 'M' => 0 );

	/**
	 * Encode text to a boolean module matrix, or null if it does not fit versions 1 to 10.
	 *
	 * @param string $text Text (treated as raw bytes).
	 * @param string $ecl  'L' or 'M'.
	 * @return array|null Rows of booleans (true = dark module).
	 */
	public static function encode( $text, $ecl = 'M' ) {
		$ecl   = isset( self::$format_bits[ $ecl ] ) ? $ecl : 'M';
		$bytes = '' === $text ? array() : array_values( unpack( 'C*', $text ) );
		$count = count( $bytes );

		$version = 0;
		for ( $v = 1; $v <= self::MAX_VERSION; $v++ ) {
			$cc_bits  = $v <= 9 ? 8 : 16;
			$capacity = self::num_data_codewords( $v, $ecl ) * 8;
			if ( 4 + $cc_bits + $count * 8 <= $capacity && $count < ( 1 << $cc_bits ) ) {
				$version = $v;
				break;
			}
		}
		if ( 0 === $version ) {
			return null;
		}

		// 1. Data bit stream: mode (0100 = byte), character count, data, terminator, padding.
		$bits = array();
		self::append_bits( $bits, 0x4, 4 );
		self::append_bits( $bits, $count, $version <= 9 ? 8 : 16 );
		foreach ( $bytes as $b ) {
			self::append_bits( $bits, $b, 8 );
		}
		$capacity_bits = self::num_data_codewords( $version, $ecl ) * 8;
		self::append_bits( $bits, 0, min( 4, $capacity_bits - count( $bits ) ) );
		self::append_bits( $bits, 0, ( 8 - count( $bits ) % 8 ) % 8 );
		for ( $pad = 0xEC; count( $bits ) < $capacity_bits; $pad ^= 0xEC ^ 0x11 ) {
			self::append_bits( $bits, $pad, 8 );
		}

		$data_codewords = array();
		for ( $i = 0, $n = count( $bits ); $i < $n; $i += 8 ) {
			$byte = 0;
			for ( $j = 0; $j < 8; $j++ ) {
				$byte = ( $byte << 1 ) | $bits[ $i + $j ];
			}
			$data_codewords[] = $byte;
		}

		// 2. Error correction and interleaving.
		$all = self::add_ecc_and_interleave( $data_codewords, $version, $ecl );

		// 3. Build the matrix.
		$size      = $version * 4 + 17;
		$modules   = array_fill( 0, $size, array_fill( 0, $size, false ) );
		$is_func   = array_fill( 0, $size, array_fill( 0, $size, false ) );

		self::draw_function_patterns( $modules, $is_func, $version, $size, $ecl );
		self::draw_codewords( $modules, $is_func, $all, $size );

		// 4. Pick the mask with the lowest penalty.
		$best_mask    = 0;
		$best_penalty = PHP_INT_MAX;
		for ( $mask = 0; $mask < 8; $mask++ ) {
			self::apply_mask( $modules, $is_func, $size, $mask );
			self::draw_format_bits( $modules, $is_func, $size, $ecl, $mask );
			$penalty = self::penalty( $modules, $size );
			if ( $penalty < $best_penalty ) {
				$best_penalty = $penalty;
				$best_mask    = $mask;
			}
			self::apply_mask( $modules, $is_func, $size, $mask ); // XOR again to undo.
		}
		self::apply_mask( $modules, $is_func, $size, $best_mask );
		self::draw_format_bits( $modules, $is_func, $size, $ecl, $best_mask );

		return $modules;
	}

	/**
	 * Render a module matrix as a standalone SVG with a 4-module white quiet zone.
	 *
	 * @param string $text Text to encode.
	 * @param int    $px   Rendered width/height in pixels.
	 * @return string SVG markup, or an empty string if the text does not fit.
	 */
	public static function svg( $text, $px = 180 ) {
		$modules = self::encode( $text, 'M' );
		if ( null === $modules ) {
			$modules = self::encode( $text, 'L' );
		}
		if ( null === $modules ) {
			return '';
		}

		$size   = count( $modules );
		$border = 4;
		$total  = $size + $border * 2;
		$path   = '';
		for ( $y = 0; $y < $size; $y++ ) {
			for ( $x = 0; $x < $size; $x++ ) {
				if ( $modules[ $y ][ $x ] ) {
					$path .= 'M' . ( $x + $border ) . ',' . ( $y + $border ) . 'h1v1h-1z';
				}
			}
		}

		return sprintf(
			'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 %1$d %1$d" width="%2$d" height="%2$d" shape-rendering="crispEdges" role="img" aria-label="Ticket QR code" style="display:block; max-width:100%%; height:auto; border-radius:6px;"><rect width="%1$d" height="%1$d" fill="#FFFFFF"/><path d="%3$s" fill="#000000"/></svg>',
			$total,
			(int) $px,
			$path
		);
	}

	// ---------------------------------------------------------------------
	// Capacity
	// ---------------------------------------------------------------------

	private static function num_raw_data_modules( $ver ) {
		$result = ( 16 * $ver + 128 ) * $ver + 64;
		if ( $ver >= 2 ) {
			$num_align = intdiv( $ver, 7 ) + 2;
			$result   -= ( 25 * $num_align - 10 ) * $num_align - 55;
			if ( $ver >= 7 ) {
				$result -= 36;
			}
		}
		return $result;
	}

	private static function num_data_codewords( $ver, $ecl ) {
		return intdiv( self::num_raw_data_modules( $ver ), 8 ) - self::$ecc_per_block[ $ecl ][ $ver ] * self::$num_blocks[ $ecl ][ $ver ];
	}

	private static function append_bits( &$bits, $value, $len ) {
		for ( $i = $len - 1; $i >= 0; $i-- ) {
			$bits[] = ( $value >> $i ) & 1;
		}
	}

	// ---------------------------------------------------------------------
	// Reed-Solomon over GF(256), polynomial 0x11D
	// ---------------------------------------------------------------------

	private static function gf_mul( $x, $y ) {
		$z = 0;
		for ( $i = 7; $i >= 0; $i-- ) {
			$z = ( $z << 1 ) ^ ( ( $z >> 7 ) * 0x11D );
			$z ^= ( ( $y >> $i ) & 1 ) * $x;
		}
		return $z;
	}

	private static function rs_divisor( $degree ) {
		$result   = array_fill( 0, $degree - 1, 0 );
		$result[] = 1;
		$root     = 1;
		for ( $i = 0; $i < $degree; $i++ ) {
			for ( $j = 0; $j < $degree; $j++ ) {
				$result[ $j ] = self::gf_mul( $result[ $j ], $root );
				if ( $j + 1 < $degree ) {
					$result[ $j ] ^= $result[ $j + 1 ];
				}
			}
			$root = self::gf_mul( $root, 0x02 );
		}
		return $result;
	}

	private static function rs_remainder( $data, $divisor ) {
		$result = array_fill( 0, count( $divisor ), 0 );
		foreach ( $data as $b ) {
			$factor = $b ^ array_shift( $result );
			$result[] = 0;
			foreach ( $divisor as $i => $coef ) {
				$result[ $i ] ^= self::gf_mul( $coef, $factor );
			}
		}
		return $result;
	}

	private static function add_ecc_and_interleave( $data, $ver, $ecl ) {
		$num_blocks      = self::$num_blocks[ $ecl ][ $ver ];
		$block_ecc_len   = self::$ecc_per_block[ $ecl ][ $ver ];
		$raw_codewords   = intdiv( self::num_raw_data_modules( $ver ), 8 );
		$num_short       = $num_blocks - $raw_codewords % $num_blocks;
		$short_block_len = intdiv( $raw_codewords, $num_blocks );

		$blocks  = array();
		$divisor = self::rs_divisor( $block_ecc_len );
		for ( $i = 0, $k = 0; $i < $num_blocks; $i++ ) {
			$dat_len = $short_block_len - $block_ecc_len + ( $i < $num_short ? 0 : 1 );
			$dat     = array_slice( $data, $k, $dat_len );
			$k      += $dat_len;
			$ecc     = self::rs_remainder( $dat, $divisor );
			if ( $i < $num_short ) {
				$dat[] = 0; // Placeholder so all blocks have equal length; skipped when interleaving.
			}
			$blocks[] = array_merge( $dat, $ecc );
		}

		$result = array();
		$len    = count( $blocks[0] );
		for ( $i = 0; $i < $len; $i++ ) {
			for ( $j = 0; $j < $num_blocks; $j++ ) {
				if ( $i !== $short_block_len - $block_ecc_len || $j >= $num_short ) {
					$result[] = $blocks[ $j ][ $i ];
				}
			}
		}
		return $result;
	}

	// ---------------------------------------------------------------------
	// Function patterns, data placement, masking
	// ---------------------------------------------------------------------

	private static function set_func( &$modules, &$is_func, $x, $y, $dark ) {
		$modules[ $y ][ $x ] = (bool) $dark;
		$is_func[ $y ][ $x ] = true;
	}

	private static function alignment_positions( $ver, $size ) {
		if ( 1 === $ver ) {
			return array();
		}
		$num_align = intdiv( $ver, 7 ) + 2;
		$step      = ( 32 === $ver ) ? 26 : (int) ( ceil( ( $ver * 4 + 4 ) / ( $num_align * 2 - 2 ) ) * 2 );
		$result    = array( 6 );
		$positions = array();
		for ( $pos = $size - 7, $n = 1; $n < $num_align; $pos -= $step, $n++ ) {
			array_unshift( $positions, $pos );
		}
		return array_merge( $result, $positions );
	}

	private static function draw_function_patterns( &$modules, &$is_func, $ver, $size, $ecl ) {
		// Timing patterns.
		for ( $i = 0; $i < $size; $i++ ) {
			self::set_func( $modules, $is_func, 6, $i, 0 === $i % 2 );
			self::set_func( $modules, $is_func, $i, 6, 0 === $i % 2 );
		}

		// Finder patterns with separators.
		foreach ( array( array( 3, 3 ), array( $size - 4, 3 ), array( 3, $size - 4 ) ) as $c ) {
			for ( $dy = -4; $dy <= 4; $dy++ ) {
				for ( $dx = -4; $dx <= 4; $dx++ ) {
					$dist = max( abs( $dx ), abs( $dy ) );
					$xx   = $c[0] + $dx;
					$yy   = $c[1] + $dy;
					if ( $xx >= 0 && $xx < $size && $yy >= 0 && $yy < $size ) {
						self::set_func( $modules, $is_func, $xx, $yy, 2 !== $dist && 4 !== $dist );
					}
				}
			}
		}

		// Alignment patterns (skip the three that would overlap finders).
		$pos  = self::alignment_positions( $ver, $size );
		$last = count( $pos ) - 1;
		for ( $i = 0; $i <= $last; $i++ ) {
			for ( $j = 0; $j <= $last; $j++ ) {
				if ( ( 0 === $i && 0 === $j ) || ( 0 === $i && $j === $last ) || ( $i === $last && 0 === $j ) ) {
					continue;
				}
				for ( $dy = -2; $dy <= 2; $dy++ ) {
					for ( $dx = -2; $dx <= 2; $dx++ ) {
						self::set_func( $modules, $is_func, $pos[ $i ] + $dx, $pos[ $j ] + $dy, 1 !== max( abs( $dx ), abs( $dy ) ) );
					}
				}
			}
		}

		// Reserve format areas (real values are written for every mask) and version information.
		self::draw_format_bits( $modules, $is_func, $size, $ecl, 0 );
		if ( $ver >= 7 ) {
			$rem = $ver;
			for ( $i = 0; $i < 12; $i++ ) {
				$rem = ( $rem << 1 ) ^ ( ( $rem >> 11 ) * 0x1F25 );
			}
			$bits = ( $ver << 12 ) | $rem;
			for ( $i = 0; $i < 18; $i++ ) {
				$bit = ( $bits >> $i ) & 1;
				$a   = $size - 11 + $i % 3;
				$b   = intdiv( $i, 3 );
				self::set_func( $modules, $is_func, $a, $b, $bit );
				self::set_func( $modules, $is_func, $b, $a, $bit );
			}
		}
	}

	private static function draw_format_bits( &$modules, &$is_func, $size, $ecl, $mask ) {
		$data = ( self::$format_bits[ $ecl ] << 3 ) | $mask;
		$rem  = $data;
		for ( $i = 0; $i < 10; $i++ ) {
			$rem = ( $rem << 1 ) ^ ( ( $rem >> 9 ) * 0x537 );
		}
		$bits = ( ( $data << 10 ) | $rem ) ^ 0x5412;

		for ( $i = 0; $i <= 5; $i++ ) {
			self::set_func( $modules, $is_func, 8, $i, ( $bits >> $i ) & 1 );
		}
		self::set_func( $modules, $is_func, 8, 7, ( $bits >> 6 ) & 1 );
		self::set_func( $modules, $is_func, 8, 8, ( $bits >> 7 ) & 1 );
		self::set_func( $modules, $is_func, 7, 8, ( $bits >> 8 ) & 1 );
		for ( $i = 9; $i < 15; $i++ ) {
			self::set_func( $modules, $is_func, 14 - $i, 8, ( $bits >> $i ) & 1 );
		}

		for ( $i = 0; $i < 8; $i++ ) {
			self::set_func( $modules, $is_func, $size - 1 - $i, 8, ( $bits >> $i ) & 1 );
		}
		for ( $i = 8; $i < 15; $i++ ) {
			self::set_func( $modules, $is_func, 8, $size - 15 + $i, ( $bits >> $i ) & 1 );
		}
		self::set_func( $modules, $is_func, 8, $size - 8, true ); // Always-dark module.
	}

	private static function draw_codewords( &$modules, $is_func, $data, $size ) {
		$total_bits = count( $data ) * 8;
		$i          = 0;
		for ( $right = $size - 1; $right >= 1; $right -= 2 ) {
			if ( 6 === $right ) {
				$right = 5;
			}
			for ( $vert = 0; $vert < $size; $vert++ ) {
				for ( $j = 0; $j < 2; $j++ ) {
					$x      = $right - $j;
					$upward = 0 === ( ( $right + 1 ) & 2 );
					$y      = $upward ? $size - 1 - $vert : $vert;
					if ( ! $is_func[ $y ][ $x ] && $i < $total_bits ) {
						$modules[ $y ][ $x ] = (bool) ( ( $data[ $i >> 3 ] >> ( 7 - ( $i & 7 ) ) ) & 1 );
						$i++;
					}
					// Remaining modules (if any) stay light, as the standard requires.
				}
			}
		}
	}

	private static function apply_mask( &$modules, $is_func, $size, $mask ) {
		for ( $y = 0; $y < $size; $y++ ) {
			for ( $x = 0; $x < $size; $x++ ) {
				switch ( $mask ) {
					case 0:  $invert = 0 === ( $x + $y ) % 2; break;
					case 1:  $invert = 0 === $y % 2; break;
					case 2:  $invert = 0 === $x % 3; break;
					case 3:  $invert = 0 === ( $x + $y ) % 3; break;
					case 4:  $invert = 0 === ( intdiv( $x, 3 ) + intdiv( $y, 2 ) ) % 2; break;
					case 5:  $invert = 0 === $x * $y % 2 + $x * $y % 3; break;
					case 6:  $invert = 0 === ( $x * $y % 2 + $x * $y % 3 ) % 2; break;
					default: $invert = 0 === ( ( $x + $y ) % 2 + $x * $y % 3 ) % 2; break;
				}
				if ( ! $is_func[ $y ][ $x ] && $invert ) {
					$modules[ $y ][ $x ] = ! $modules[ $y ][ $x ];
				}
			}
		}
	}

	/**
	 * Mask penalty score (ISO 18004 rules 1 to 4). Only affects which mask is chosen,
	 * never whether the code is valid.
	 */
	private static function penalty( $modules, $size ) {
		$score = 0;
		$dark  = 0;
		$lines = array();

		for ( $y = 0; $y < $size; $y++ ) {
			$row = '';
			for ( $x = 0; $x < $size; $x++ ) {
				$row .= $modules[ $y ][ $x ] ? '1' : '0';
				$dark += $modules[ $y ][ $x ] ? 1 : 0;
			}
			$lines[] = $row;
		}
		for ( $x = 0; $x < $size; $x++ ) {
			$col = '';
			for ( $y = 0; $y < $size; $y++ ) {
				$col .= $modules[ $y ][ $x ] ? '1' : '0';
			}
			$lines[] = $col;
		}

		foreach ( $lines as $line ) {
			// Rule 1: runs of five or more.
			if ( preg_match_all( '/0{5,}|1{5,}/', $line, $m ) ) {
				foreach ( $m[0] as $run ) {
					$score += 3 + ( strlen( $run ) - 5 );
				}
			}
			// Rule 3: finder-like 1:1:3:1:1 patterns with four light modules on a side.
			$score += 40 * preg_match_all( '/(?=10111010000|00001011101)/', $line );
		}

		// Rule 2: 2x2 blocks of one colour.
		for ( $y = 0; $y < $size - 1; $y++ ) {
			for ( $x = 0; $x < $size - 1; $x++ ) {
				$c = $modules[ $y ][ $x ];
				if ( $c === $modules[ $y ][ $x + 1 ] && $c === $modules[ $y + 1 ][ $x ] && $c === $modules[ $y + 1 ][ $x + 1 ] ) {
					$score += 3;
				}
			}
		}

		// Rule 4: balance of dark and light modules.
		$total = $size * $size;
		$k     = (int) ceil( abs( $dark * 20 - $total * 10 ) / $total ) - 1;
		$score += max( 0, $k ) * 10;

		return $score;
	}
}
