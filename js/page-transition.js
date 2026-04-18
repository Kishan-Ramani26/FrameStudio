// --- PAGE TRANSITION (Barba.js + SVG Path Animation) ---
(function () {
  const overlay = document.getElementById('transition-overlay');
  const path = document.getElementById('transition-path');

  if (!overlay || !path) return;

  let isTransitioning = false;
  let overlayAnim = null;
  let pathAnim = null;
  let transitionTimeout = null;
  let clickLock = false;
  let clickLockTimeout = null;

  // Responsive animation parameters — FAST timings
  function getAnimParams() {
    const w = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
    const h = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0);
    const aspectRatio = h / Math.max(w, 1);
    const longestSide = Math.max(w, h);

    if (w <= 480) {
      return {
        bigStroke: aspectRatio > 1.8 ? Math.max(280, Math.round(longestSide * 0.28)) : 240,
        pathDuration: 600,
        overlayDuration: 250
      };
    }

    if (w <= 900) {
      return {
        bigStroke: aspectRatio > 1.5 ? Math.max(300, Math.round(longestSide * 0.24)) : 240,
        pathDuration: 700,
        overlayDuration: 300
      };
    }

    return { bigStroke: 300, pathDuration: 800, overlayDuration: 300 };
  }

  // Cancel any running animations to prevent stacking
  function cancelAnimations() {
    if (overlayAnim) { try { overlayAnim.cancel(); } catch (e) {} overlayAnim = null; }
    if (pathAnim) { try { pathAnim.cancel(); } catch (e) {} pathAnim = null; }
  }

  function clearClickLock() {
    if (clickLockTimeout) {
      clearTimeout(clickLockTimeout);
      clickLockTimeout = null;
    }
    clickLock = false;
  }

  function setClickLock(timeoutMs) {
    clearClickLock();
    clickLock = true;
    clickLockTimeout = setTimeout(function () {
      clickLock = false;
      clickLockTimeout = null;
    }, Math.max(0, timeoutMs || 0));
  }

  function clearSafetyTimer() {
    if (transitionTimeout) {
      clearTimeout(transitionTimeout);
      transitionTimeout = null;
    }
  }

  function scheduleSafetyReset(timeoutMs) {
    clearSafetyTimer();
    transitionTimeout = setTimeout(function () {
      if (isTransitioning) {
        resetOverlay();
        isTransitioning = false;
      }
    }, Math.max(0, timeoutMs || 0));
  }

  function finalizeTransition() {
    clearSafetyTimer();
    resetOverlay();
    isTransitioning = false;
    clearClickLock();
  }

  function safeFinished(anim, fallbackMs) {
    var fallback = Math.max(0, fallbackMs || 0);
    var fallbackPromise = new Promise(function (resolve) {
      setTimeout(resolve, fallback);
    });
    if (!anim || !anim.finished) {
      return fallbackPromise;
    }
    return Promise.race([
      anim.finished.catch(function () {}),
      fallbackPromise
    ]);
  }

  function animateOverlayOpacity(from, to, durationMs, delayMs) {
    overlay.style.visibility = 'visible';
    if (!overlay.animate) {
      overlay.style.opacity = String(to);
      return Promise.resolve();
    }
    overlayAnim = overlay.animate(
      [{ opacity: from }, { opacity: to }],
      { duration: durationMs, delay: delayMs || 0, easing: 'cubic-bezier(0.4,0,0.2,1)', fill: 'forwards' }
    );
    return safeFinished(overlayAnim, durationMs + (delayMs || 0));
  }

  function animatePathLeave() {
    var p = getAnimParams();
    if (!path.animate) {
      path.style.strokeDasharray = '1 0';
      path.style.strokeDashoffset = '0';
      path.style.strokeWidth = String(p.bigStroke);
      return Promise.resolve();
    }
    pathAnim = path.animate(
      [
        { strokeDasharray: '0 1', strokeDashoffset: 0, strokeWidth: 2 },
        { strokeDasharray: '1 0', strokeDashoffset: 0, strokeWidth: p.bigStroke }
      ],
      { duration: p.pathDuration, easing: 'cubic-bezier(0.4,0,0.2,1)', fill: 'forwards' }
    );
    return safeFinished(pathAnim, p.pathDuration);
  }

  function animatePathEnter() {
    var p = getAnimParams();
    if (!path.animate) {
      path.style.strokeDasharray = '0 1';
      path.style.strokeDashoffset = '-1';
      path.style.strokeWidth = '2';
      return Promise.resolve();
    }
    pathAnim = path.animate(
      [
        { strokeDasharray: '1 0', strokeDashoffset: 0, strokeWidth: p.bigStroke },
        { strokeDasharray: '0 1', strokeDashoffset: -1, strokeWidth: 2 }
      ],
      { duration: p.pathDuration, easing: 'cubic-bezier(0.4,0,0.2,1)', fill: 'forwards' }
    );
    return safeFinished(pathAnim, p.pathDuration);
  }

  function resetOverlay() {
    cancelAnimations();
    overlay.style.opacity = '0';
    overlay.style.visibility = 'hidden';
    path.style.strokeDasharray = '0 1';
    path.style.strokeDashoffset = '0';
    path.style.strokeWidth = '2';
    // Clear any leftover Web Animation API effects
    overlay.getAnimations().forEach(function (a) { a.cancel(); });
    path.getAnimations().forEach(function (a) { a.cancel(); });
  }

  function shouldHandleLink(el) {
    if (!el || el.tagName !== 'A') return false;
    if (el.hasAttribute('download')) return false;
    var href = el.getAttribute('href') || '';
    if (!href || href.charAt(0) === '#') return false;
    if (href.indexOf('javascript:') === 0) return false;
    if (el.getAttribute('target') === '_blank') return false;
    if (el.protocol && el.protocol !== ':' && el.protocol !== 'http:' && el.protocol !== 'https:') return false;
    if (el.href && el.href.indexOf(window.location.origin) === -1) return false;
    if (href.indexOf('/references') !== -1 || href.indexOf('/401') !== -1) return false;
    if (el.hash && el.pathname === window.location.pathname && el.search === window.location.search) return false;
    return true;
  }

  document.addEventListener('click', function (event) {
    if (event.defaultPrevented) return;
    if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
    var link = event.target && event.target.closest ? event.target.closest('a[href]') : null;
    if (!link) return;

    if (isTransitioning || clickLock) {
      event.preventDefault();
      event.stopImmediatePropagation();
      return;
    }

    if (shouldHandleLink(link)) {
      setClickLock(700);
    }
  }, true);

  // Re-init page scripts after Barba swap
  function reinitPage(data) {
    var container = data.next && data.next.container ? data.next.container : document;

    // Barba swaps only the container; keep Webflow page metadata in sync manually.
    if (data.next && data.next.html) {
      try {
        var nextDoc = new DOMParser().parseFromString(data.next.html, 'text/html');
        var nextHtml = nextDoc.documentElement;
        var nextBody = nextDoc.body;

        ['data-wf-page', 'data-wf-site', 'lang'].forEach(function (attr) {
          var val = nextHtml.getAttribute(attr);
          if (val) {
            document.documentElement.setAttribute(attr, val);
          } else {
            document.documentElement.removeAttribute(attr);
          }
        });

        if (nextBody && typeof nextBody.className === 'string') {
          document.body.className = nextBody.className;
        }

        if (nextDoc.title) {
          document.title = nextDoc.title;
        }
      } catch (e) {}
    }

    // Kill old ScrollTriggers
    if (typeof ScrollTrigger !== 'undefined') {
      ScrollTrigger.getAll().forEach(function (t) { t.kill(); });
    }

    // Re-init Lenis
    if (typeof Lenis !== 'undefined') {
      // Remove old ticker callback
      if (window._lenisTickerFn) {
        gsap.ticker.remove(window._lenisTickerFn);
      }
      if (window._lenisInstance) {
        try { window._lenisInstance.destroy(); } catch (e) {}
      }
      var lenis = new Lenis({
        smooth: true,
        smoothTouch: false,
        syncTouch: true,
        duration: 1.1,
        lerp: 0.15,
        easing: function (t) { return 1 - Math.pow(2, -10 * t); },
        wheelMultiplier: 0.8,
        touchMultiplier: 1.35,
        normalizeWheel: true,
        autoResize: true
      });
      window._lenisInstance = lenis;
      // Sync Lenis with ScrollTrigger
      lenis.on('scroll', ScrollTrigger.update);
      window._lenisTickerFn = function (time) {
        lenis.raf(time * 1000);
      };
      gsap.ticker.add(window._lenisTickerFn);
      gsap.ticker.lagSmoothing(0);
    }

    // Re-init Webflow interactions
    if (window.Webflow) {
      try {
        window.Webflow.destroy();
        window.Webflow.ready();
        if (window.Webflow.require('ix2')) {
          window.Webflow.require('ix2').init();
        }
        document.dispatchEvent(new Event('readystatechange'));
      } catch (e) {}
    }

    // Re-run card animation if available
    if (typeof window._runPageAnimationsFor === 'function') {
      window._runPageAnimationsFor(container || document);
    } else if (typeof window._initCardAnimation === 'function') {
      window._initCardAnimation(container || document);
    }

    // Lazy load hero video on new page
    var video = container.querySelector('.hero-background-video video');
    if (video && video.preload === 'none') {
      video.preload = 'auto';
      video.load();
      video.play().catch(function () {});
    }

    // Refresh ScrollTrigger after DOM settles
    requestAnimationFrame(function () {
      if (typeof ScrollTrigger !== 'undefined') {
        ScrollTrigger.refresh();
      }
      window.scrollTo(0, 0);
      window.dispatchEvent(new Event('scroll'));
      window.dispatchEvent(new Event('resize'));
    });
  }

  // Initialize Barba.js for multi-page transitions
  if (window.barba) {
    barba.init({
      preventRunning: true,
      prevent: function (data) {
        var el = data.el;
        if (!el) return false;
        var href = el.getAttribute('href') || '';
        // Skip external links
        if (el.href && el.href.indexOf(window.location.origin) === -1) return true;
        // Skip links with target="_blank"
        if (el.getAttribute('target') === '_blank') return true;
        // Skip anchor-only links
        if (href.charAt(0) === '#') return true;
        // Skip non-page links (references, changelog, etc.)
        if (href.indexOf('/references') !== -1 || href.indexOf('/401') !== -1) return true;
        // Prevent transition if already transitioning
        if (isTransitioning) return true;
        return false;
      },
      timeout: 8000,
      // If Barba fails to fetch a page, gracefully fallback to normal navigation
      requestError: function (trigger, action, url, response) {
        // Reset overlay in case it got stuck
        finalizeTransition();
        // Fallback to normal navigation
        if (action === 'click') {
          barba.force(url);
        }
        return false;
      },
      transitions: [{
        name: 'svg-path-transition',

        // LEAVE: Cover screen with SVG stroke
        async leave(data) {
          isTransitioning = true;
          cancelAnimations();
          var p = getAnimParams();
          scheduleSafetyReset(p.pathDuration + p.overlayDuration + 2000);

          window.scrollTo({ top: 0, behavior: 'auto' });

          await Promise.allSettled([
            animateOverlayOpacity(0, 1, p.overlayDuration),
            animatePathLeave()
          ]);

          // Hide old content immediately
          if (data.current && data.current.container) {
            data.current.container.style.display = 'none';
          }
        },

        // ENTER: Reveal new page — runs AFTER Barba inserts new container
        async enter(data) {
          var p = getAnimParams();
          var container = data.next && data.next.container ? data.next.container : null;

          // Make sure new container is fully visible instantly
          if (container) {
            container.style.opacity = '1';
            container.style.visibility = 'visible';
          }

          scheduleSafetyReset(p.pathDuration + p.overlayDuration + 2000);

          try {
            // Reinit scripts NOW while overlay still covers screen
            reinitPage(data);

            // Start reveal — path shrinks back, overlay fades
            // Run BOTH in parallel, no artificial delay
            await Promise.allSettled([
              animatePathEnter(),
              animateOverlayOpacity(1, 0, p.overlayDuration, Math.max(0, p.pathDuration - p.overlayDuration))
            ]);
          } finally {
            finalizeTransition();
          }
        }
      }]
    });

    // Error recovery — if Barba fetch fails, do a normal page load
    barba.hooks.after(function () {
      if (isTransitioning) {
        finalizeTransition();
      }
    });

    // If something goes wrong, always reset state
    window.addEventListener('error', function () {
      if (isTransitioning) {
        finalizeTransition();
      }
    });

    // BFCache/visibility recovery — never leave overlay stuck
    window.addEventListener('pageshow', function () {
      finalizeTransition();
    });
    document.addEventListener('visibilitychange', function () {
      if (document.visibilityState === 'visible' && isTransitioning) {
        finalizeTransition();
      }
    });
  }
})();
