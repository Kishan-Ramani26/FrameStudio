// --- FIXED JS: Consolidated Listeners & Safe Initialization ---
document.addEventListener("DOMContentLoaded", () => {
  // --- 1. GSAP & SCROLLTRIGGER (register first so plugins are available) ---
  gsap.registerPlugin(ScrollTrigger, CustomEase);

  // --- 2. LENIS SMOOTH SCROLL ---
  if (typeof Lenis !== "undefined") {
    const lenis = new Lenis({
      smooth: true,
      smoothTouch: false, 
      syncTouch: true,
      duration: 1.1,
      lerp: 0.15,
      easing: (t) => 1 - Math.pow(2, -10 * t),
      wheelMultiplier: 0.8,
      touchMultiplier: 1.35,
      normalizeWheel: true,
      autoResize: true,
    });
    window._lenisInstance = lenis;

    // Sync Lenis scroll with GSAP ScrollTrigger
    lenis.on('scroll', ScrollTrigger.update);
    window._lenisTickerFn = (time) => {
      lenis.raf(time * 1000);
    };
    gsap.ticker.add(window._lenisTickerFn);
    gsap.ticker.lagSmoothing(0);

    // Ensure we start at top without weird offsets
    window.scrollTo(0, 0);
  }

  // Custom Ease "Hop"
  CustomEase.create(
    "hop",
    "M0,0 C0.084,0.61 0.214,0.802 0.28,0.856 0.356,0.918 0.374,1 1,1",
  );

  // --- 3. PRELOADER LOGIC ---
  const preloader = document.querySelector(".preloader");
  const logo = document.querySelector("#logo-text");
  const preloaderEnabled =
    preloader && preloader.dataset && preloader.dataset.enabled === "true";

  // Lazy load hero video after preloader
  const loadHeroVideo = () => {
    const video = document.querySelector('.hero-background-video video');
    if (video && video.preload === 'none') {
      video.preload = 'auto';
      video.load();
      video.play().catch(() => {}); // Autoplay may be blocked
    }
  };

  // Cleanup helper
  const removePreloader = () => {
    if (preloader) {
      gsap.to(preloader, {
        autoAlpha: 0,
        duration: 0.5,
        onComplete: () => {
          preloader.remove();
          loadHeroVideo(); // Start video after preloader is gone
        },
      });
    }
    document.body.style.overflow = ""; // Ensure scrolling is re-enabled
    document.documentElement.style.overflow = "";
    ScrollTrigger.refresh(); // Refresh ST after preloader is gone
  };

  // Failsafe: Remove preloader after 5s if it hasn't been removed yet
  if (preloader) {
    setTimeout(() => {
      if (document.querySelector(".preloader")) {
        console.warn("Preloader timed out, removing forcefully.");
        removePreloader();
        runPageAnimations();
      }
    }, 5000);
  }

  if (!preloaderEnabled || !logo) {
    // Skip animation, remove immediately
    if (preloader) preloader.remove();
    // Ensure overflow is reset just in case
    document.body.style.overflow = "";
    document.documentElement.style.overflow = "";
    loadHeroVideo(); // Load video immediately
    // Proceed to page animations
    runPageAnimations();
  } else {
    // Mark that preloader has been shown this session
    try { sessionStorage.setItem('preloaderShown', '1'); } catch (e) {}
    // Run Preloader Animation
    runPreloaderAnimation(logo, removePreloader);
  }

  // --- 4. PAGE ANIMATIONS (ScrollTrigger) ---
  let pageAnimationsRun = false;
  function runPageAnimations() {
    if (!pageAnimationsRun) {
      pageAnimationsRun = true;

      // Re-run after all assets are loaded for stable ScrollTrigger pin metrics.
      window.addEventListener("load", () => {
        runPageAnimationsFor(document);
        ScrollTrigger.refresh();
      }, { once: true });
      window.addEventListener("resize", () => ScrollTrigger.refresh());

      // Expose for Barba page transitions
      window._runPageAnimations = runPageAnimations;
      window._runPageAnimationsFor = runPageAnimationsFor;
      window._initCardAnimation = initCardAnimation;
    }

    runPageAnimationsFor(document);
  }

  function runPageAnimationsFor(root) {
    const scope = root || document;

    initCardAnimation(scope);

    // FORCE HERO SECTION TO REVEAL
    // Webflow sets these to opacity:0 initially for scroll-into-view animations
    // Since we're already at top, manually reveal them
    const heroElements = scope.querySelectorAll('.hero-01 [data-w-id], .hero-01-text-wrap, .hero-01-bottom-wrap');
    heroElements.forEach(el => {
      gsap.to(el, {
        opacity: 1,
        y: 0,
        filter: 'blur(0px)',
        duration: 0.6,
        ease: 'power2.out',
        clearProps: 'filter'
      });
    });

    // Also reveal h1 and paragraph specifically
    const heroText = scope.querySelectorAll('.hero-01 .h1, .hero-01 .paragraph-03');
    if (heroText.length) {
      gsap.to(heroText, {
        opacity: 1,
        y: 0,
        filter: 'blur(0px)',
        duration: 0.8,
        stagger: 0.15,
        ease: 'power2.out',
        clearProps: 'filter'
      });
    }

    // Wake up scroll-based interactions after swaps
    requestAnimationFrame(() => {
      ScrollTrigger.refresh();
      window.dispatchEvent(new Event('scroll'));
      window.dispatchEvent(new Event('resize'));
    });
  }

  function runPreloaderAnimation(logoElement, onCompleteCallback) {
    const text = logoElement.textContent;
    logoElement.innerHTML = "";

    text.split("").forEach((char) => {
      const span = document.createElement("span");
      span.classList.add("char");
      span.textContent = char;
      logoElement.appendChild(span);
    });

    const chars = document.querySelectorAll(".char");
    if (chars.length === 0) {
      onCompleteCallback();
      return;
    }

    const firstChar = chars[0];
    let sIndex = Array.from(chars).findIndex((c) => c.textContent === "S");
    if (sIndex === -1 || sIndex === 0) sIndex = chars.length - 1;
    const lastChar = chars[sIndex];
    const middleChars = Array.from(chars).filter(
      (c, i) => i !== 0 && i !== sIndex,
    );

    const tl = gsap.timeline({ delay: 0.5 });

    // Enter
    tl.to(".progress-bar", {
      width: "100%",
      duration: 0.4,
      ease: "power2.inOut",
    })
      .to(".progress-bar", { scaleY: 0, transformOrigin: "top", duration: 0.3 })
      .to(".preloader-header", { opacity: 1, duration: 0.3 });

    const imageWrappers = document.querySelectorAll(".image-wrapper");
    const images = document.querySelectorAll(".image-wrapper img");

    tl.to(
      imageWrappers,
      {
        clipPath: "polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%)",
        stagger: 0.1,
        duration: 1,
        ease: "hop",
      },
      "-=0.5",
    ).to(
      images,
      {
        scale: 1,
        stagger: 0.1,
        duration: 1,
        ease: "power2.out",
      },
      "<",
    );

    tl.to(
      chars,
      {
        y: 0,
        stagger: { each: 0.03, from: "random", ease: "hop" },
        duration: 0.5,
        ease: "hop",
      },
      "-=1",
    );

    // Exit
    tl.to({}, { duration: 0.05 });
    tl.to(imageWrappers, {
      clipPath: "polygon(0% 100%, 100% 100%, 100% 100%, 0% 100%)",
      stagger: 0.05,
      duration: 0.3,
      ease: "power3.in",
    });
    tl.to(
      middleChars,
      {
        y: "-100%",
        opacity: 0,
        stagger: { each: 0.03, from: "random", ease: "hop" },
        duration: 0.3,
        ease: "power2.in",
      },
      "<",
    );

    tl.add(() => {
      const firstRect = firstChar.getBoundingClientRect();
      const lastRect = lastChar.getBoundingClientRect();
      const center = window.innerWidth / 2;
      const firstDist = center - firstRect.left - firstRect.width / 2;
      const lastDist = center - lastRect.left - lastRect.width / 2;
      const isMobile = window.innerWidth < 768;
      const gap = isMobile ? 8 : 20;

      gsap.to(firstChar, {
        x: firstDist - gap,
        duration: 0.5,
        ease: "hop",
        color: "#00a8ff",
      });
      gsap.to(lastChar, {
        x: lastDist + gap,
        duration: 0.5,
        ease: "hop",
        color: "#00a8ff",
      });
    });

    tl.to(".preloader-header", {
      top: "2rem",
      scale: 0.5,
      duration: 1,
      ease: "power3.inOut",
    });

    tl.to(
      ".preloader",
      {
        clipPath: "polygon(0% 0%, 100% 0%, 100% 0%, 0% 0%)",
        duration: 0.7,
        ease: "power3.inOut",
        onComplete: () => {
          onCompleteCallback(); // Cleanup
          runPageAnimations(); // Start page logic
        },
      },
      "-=0.8",
    );
  }

  function initCardAnimation(root) {
    const scope = root || document;
    const stickySection = scope.querySelector(".three-paths .sticky-section");
    const cardContainer = scope.querySelector(".three-paths .card-container");
    const cards = scope.querySelectorAll(".three-paths .card");
    const card1 = scope.querySelector("#card-1");
    const card3 = scope.querySelector("#card-3");

    if (!stickySection || !cardContainer || !cards.length) return;

    // Always recreate to avoid stale triggers after hard refresh edge-cases.
    if (window._threePathsST) {
      window._threePathsST.kill();
      window._threePathsST = null;
    }

    // Keep mobile static by design.
    if (window.matchMedia("(max-width: 768px)").matches) {
      gsap.set(cardContainer, { clearProps: "all" });
      gsap.set(cards, { clearProps: "transform,borderRadius" });
      return;
    }

    let isGapAnimDone = false;
    let isFlipAnimDone = false;

    window._threePathsST = ScrollTrigger.create({
      trigger: stickySection,
      start: "top top",
      end: "+=400%",
      pin: true,
      anticipatePin: 1,
      invalidateOnRefresh: true,
      scrub: true,
      onUpdate: (self) => {
        const progress = self.progress;

        if (progress <= 0.25) {
          const t = progress / 0.25;
          const newWidth = gsap.utils.interpolate(30, 80, t);
          gsap.set(cardContainer, { width: `${newWidth}%` });
        } else {
          gsap.set(cardContainer, { width: "80%" });
        }

        if (progress > 0.35 && !isGapAnimDone) {
          isGapAnimDone = true;
          gsap.to(cardContainer, { gap: "2rem", duration: 0.5, ease: "power2.out" });
          gsap.to(cards, { borderRadius: "15px", duration: 0.5, ease: "power2.out" });
        } else if (progress < 0.35 && isGapAnimDone) {
          isGapAnimDone = false;
          gsap.to(cardContainer, { gap: "0rem", duration: 0.5, ease: "power2.out" });
          gsap.to(cards, {
            borderRadius: "0px",
            duration: 0.5,
            ease: "power2.out",
            onComplete: () => {
              if (card1) gsap.set(card1, { borderTopLeftRadius: "12px", borderBottomLeftRadius: "12px" });
              if (card3) gsap.set(card3, { borderTopRightRadius: "12px", borderBottomRightRadius: "12px" });
            },
          });
        }

        if (progress > 0.7 && !isFlipAnimDone) {
          isFlipAnimDone = true;
          gsap.to(cards, { rotateY: 180, stagger: 0.1, duration: 1, ease: "power3.out" });
          if (card1) gsap.to(card1, { y: 40, rotateZ: -3, duration: 1, delay: 0.1, ease: "power3.out" });
          if (card3) gsap.to(card3, { y: 40, rotateZ: 3, duration: 1, delay: 0.1, ease: "power3.out" });
        } else if (progress < 0.7 && isFlipAnimDone) {
          isFlipAnimDone = false;
          gsap.to(cards, { rotateY: 0, stagger: { each: 0.1, from: "end" }, duration: 1.2, ease: "sine.out" });
          if (card1) gsap.to(card1, { y: 0, rotateZ: 0, duration: 1.2, ease: "sine.out" });
          if (card3) gsap.to(card3, { y: 0, rotateZ: 0, duration: 1.2, ease: "sine.out" });
        }
      },
    });
  }
});
