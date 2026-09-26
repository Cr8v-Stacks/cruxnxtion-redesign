/**
 * Crux Nxtion Theme - Main Client Interaction & Navigation Controller
 */
document.addEventListener('DOMContentLoaded', function () {
  // Mobile Navigation Drawer Controller
  var toggleBtn = document.getElementById('crux-mnav-toggle') || document.querySelector('.mnav-btn, [aria-label="Open navigation menu"]');
  var closeBtn = document.getElementById('crux-mdrawer-close') || document.querySelector('.mdrawer-close-btn');
  var drawer = document.getElementById('crux-mobile-drawer') || document.querySelector('.mdrawer');

  function openDrawer() {
    if (!drawer) return;
    drawer.classList.add('is-open');
    document.body.classList.add('drawer-open');
    document.documentElement.classList.add('drawer-open');
    if (toggleBtn) {
      toggleBtn.setAttribute('aria-expanded', 'true');
    }
  }

  function closeDrawer() {
    if (!drawer) return;
    drawer.classList.remove('is-open');
    document.body.classList.remove('drawer-open');
    document.documentElement.classList.remove('drawer-open');
    if (toggleBtn) {
      toggleBtn.setAttribute('aria-expanded', 'false');
    }
  }

  if (toggleBtn) {
    toggleBtn.addEventListener('click', function (e) {
      e.preventDefault();
      if (drawer && drawer.classList.contains('is-open')) {
        closeDrawer();
      } else {
        openDrawer();
      }
    });
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', function (e) {
      e.preventDefault();
      closeDrawer();
    });
  }

  if (drawer) {
    // Close on clicking backdrop outside content
    drawer.addEventListener('click', function (e) {
      if (e.target === drawer) {
        closeDrawer();
      }
    });

    // Close when navigating via links
    var drawerLinks = drawer.querySelectorAll('a:not(.acc-toggle)');
    drawerLinks.forEach(function (link) {
      link.addEventListener('click', function () {
        closeDrawer();
      });
    });
  }

  // Close on Escape key
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && drawer && drawer.classList.contains('is-open')) {
      closeDrawer();
    }
  });

  // Legacy fallback if any checkbox remains during transition
  var mnavCheckbox = document.getElementById('mnav');
  if (mnavCheckbox) {
    var legacyLinks = document.querySelectorAll('.mdrawer a');
    legacyLinks.forEach(function (link) {
      link.addEventListener('click', function () {
        mnavCheckbox.checked = false;
      });
    });
  }
});

