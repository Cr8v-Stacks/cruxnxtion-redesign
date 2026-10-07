<?php
/**
 * Repo hygiene test (no WordPress needed): fails on a UTF-8 byte-order mark or double-encoded
 * characters (for example an em dash saved as three garbage characters) in any PHP, JS or CSS file.
 * Both were introduced once by scripted edits and shipped garbage to visitors and browser titles.
 *
 *   php cr8v-event-ticketing/tests/test_repo_hygiene.php
 */
// Self-check: the detector must recognise a known garbled em dash, otherwise a clean result means nothing.
if ( ! preg_match( '/\xC3\xA2\xE2\x82\xAC/', "\xC3\xA2\xE2\x82\xAC\xE2\x80\x9D" ) ) {
	echo "FAIL  detector self-check\n";
	exit( 1 );
}

$root  = dirname( __DIR__, 2 );
$fail  = 0;
$files = 0;
$it    = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $root, FilesystemIterator::SKIP_DOTS ) );
foreach ( $it as $file ) {
	$path = $file->getPathname();
	if ( preg_match( '#[\\\\/](\.git|node_modules|design|dist)[\\\\/]#', $path ) || ! preg_match( '/\.(php|js|css)$/', $path ) ) {
		continue;
	}
	$files++;
	$bytes = file_get_contents( $path );
	$rel   = substr( $path, strlen( $root ) + 1 );
	if ( 0 === strncmp( $bytes, "\xEF\xBB\xBF", 3 ) ) {
		echo "FAIL  byte-order mark: $rel\n";
		$fail++;
	}
	// A lead byte (C2-F4) followed by continuation bytes, re-read as Windows-1252 and re-saved as UTF-8,
	// appears as these character pairs. Real text never contains them.
	if ( preg_match( '/\xC3\xA2\xE2\x82\xAC|\xC3\x83[\xC2\x82-\xC2\xBF]|\xC3\x82[\xC2\x80-\xC2\xBF]/', $bytes ) ) {
		echo "FAIL  double-encoded characters: $rel\n";
		$fail++;
	}
	if ( ! preg_match( '//u', $bytes ) ) {
		echo "FAIL  not valid UTF-8: $rel\n";
		$fail++;
	}
}
echo "\nRESULT: scanned $files files, $fail problem(s)\n";
exit( $fail ? 1 : 0 );