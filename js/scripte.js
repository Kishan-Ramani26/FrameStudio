


document.addEventListener("DOMContentLoaded", () => {
  gsap.registerPlugin(CustomEase);

  // 1. SETUP: Custom Ease "Hop"
  CustomEase.create(
    "hop",
    "M0,0 C0.084,0.61 0.214,0.802 0.28,0.856 0.356,0.918 0.374,1 1,1"
  );

  // 2. HELPER: Split Text Manually (Since we don't have the paid plugin)
  const logo = document.querySelector("#logo-text");
  const text = logo.textContent;
  logo.innerHTML = ""; // Clear text

  // Create span for each char
  text.split("").forEach((char) => {
    const span = document.createElement("span");
    span.classList.add("char");
    span.textContent = char;
    logo.appendChild(span);
  });

  const chars = document.querySelectorAll(".char");
  const firstChar = chars[0];
  const lastChar = chars[chars.length - 1];
  const middleChars = Array.from(chars).slice(1, -1);

  // 3. ANIMATION TIMELINE
  const tl = gsap.timeline({ delay: 0.5 });

  // --- A. LOADING SEQUENCE ---

  // Progress Bar
  tl.to(".progress-bar", {
    width: "100%",
    duration: .5,
    ease: "power2.inOut",
  }).to(".progress-bar", {
    scaleY: 0,
    transformOrigin: "top",
    duration: 0.3,
  }).to(".preloader-header", {
    opacity: 1,
    duration: 0.3,
  });

  // Images Reveal (Unfold Up)
  const imageWrappers = document.querySelectorAll(".image-wrapper");
  const images = document.querySelectorAll(".image-wrapper img");

  tl.to(
    imageWrappers,
    {
      clipPath: "polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%)", // Reveal
      stagger: 0.1,
      duration: 1,
      ease: "hop",
    },
    "-=0.5"
  ) // Overlap with progress bar

    // Image Scale (Zoom Out effect)
    .to(
      images,
      {
        scale: 1,
        stagger: 0.1,
        duration: 1,
        ease: "power2.out",
      },
      "<"
    ); // Run at start of wrapper anim

  // Text Reveal (Staggered Bounce)
  tl.to(
    chars,
    {
      y: 0,
      stagger: 0.05,
      duration: 0.5,
      ease: "hop",
    },
    "-=1"
  )

  // --- B. EXIT / TRANSITION SEQUENCE ---
  // Wait a beat
  tl.to({}, { duration: 0.05 });

  // 1. Collapse Images
  tl.to(imageWrappers, {
    clipPath: "polygon(0% 100%, 100% 100%, 100% 100%, 0% 100%)", // Hide downwards
    stagger: 0.05,
    duration: 0.3,
    ease: "power3.in",
  });

  // 2. Hide Middle Letters (Fly away)
  tl.to(
    middleChars,
    {
      y: "-100%", // Fly up
      stagger: 0.03,
      duration: 0.3,
      ease: "power2.in",
    },
    "<"
  );

  // 3. THE "LOGO MOVE" CALCULATION
  // We want the first and last letters to meet in the center
  tl.add(() => {
    // Get current positions
    const firstRect = firstChar.getBoundingClientRect();
    const lastRect = lastChar.getBoundingClientRect();
    const containerRect = document
      .querySelector(".preloader-header")
      .getBoundingClientRect();

    // Calculate distance to center
    const center = window.innerWidth / 2;
    const firstDist = center - firstRect.left - firstRect.width / 2;
    const lastDist = center - lastRect.left - lastRect.width / 2;

    // We move them slightly apart to form a compact logo, not overlapping
    const gap = 20;

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

  // 4. Move Header to Top (Navbar position)
  tl.to(".preloader-header", {
    top: "2rem",
    scale: 0.5, // Shrink
    duration: 1,
    ease: "power3.inOut",
  });

  // 5. Reveal Hero (Lift Curtain)
  tl.to(
    ".preloader",
    {
      clipPath: "polygon(0% 0%, 100% 0%, 100% 0%, 0% 0%)", // Wipe up
      duration: 0.7,
      ease: "power3.inOut",
      onComplete: () => {
      const preloader = document.querySelector(".preloader");
      if (preloader) preloader.remove();
    },  
    },
    "-=0.8"
  ); // Overlap with logo move
});


document.addEventListener("DOMContentLoaded", () => {
  if (typeof Lenis !== "undefined") {
    const lenis = new Lenis({
      smooth: true, // Desktop smooth scrolling
      smoothTouch: false, // Keep native fast touch scrolling (best for GSAP)
      syncTouch: true, // Prevent scroll desync inside sliders
      duration: 1.1, // Apple-style glide
      lerp: 0.15, // Smooth but responsive
      easing: (t) => 1 - Math.pow(2, -10 * t), // Premium Apple-like easing
      wheelMultiplier: 0.8, // Slower, softer wheel movement
      touchMultiplier: 1.35, // Balanced swipe (not too fast like 2)
      normalizeWheel: true, // Consistent scroll across devices
      autoResize: true, // Adjusts smoothly on resize
    });

    function raf(time) {
      lenis.raf(time);
      requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);
  }

  gsap.registerPlugin(ScrollTrigger);

  let isGapAnimDone = false;
  let isFlipAnimDone = false;

  function mapRange(inMin, inMax, outMin, outMax, value) {
    return outMin + ((value - inMin) * (outMax - outMin)) / (inMax - inMin);
  }

  function initAnimation() {
    let mm = gsap.matchMedia();

    mm.add("(min-width: 769px)", () => {
      ScrollTrigger.create({
        trigger: ".sticky-section",
        start: "top top",
        end: "+=400%",
        pin: true,
        scrub: 1,
        onUpdate: (self) => {
          const progress = self.progress;

          // --------------------------
          // PHASE 1
          // --------------------------
          if (progress <= 0.25) {
            const t = progress / 0.25;
            const newWidth = gsap.utils.interpolate(30, 80, t);
            gsap.set(".card-container", { width: `${newWidth}%` });
          } else {
            gsap.set(".card-container", { width: "80%" });
          }

          // --------------------------
          // PHASE 2
          // --------------------------
          if (progress > 0.35 && !isGapAnimDone) {
            isGapAnimDone = true;

            gsap.to(".card-container", {
              gap: "2rem",
              duration: 0.5,
              ease: "power2.out",
            });
            gsap.to(".card", {
              borderRadius: "15px",
              duration: 0.5,
              ease: "power2.out",
            });
          } else if (progress < 0.35 && isGapAnimDone) {
            isGapAnimDone = false;

            gsap.to(".card-container", {
              gap: "0rem",
              duration: 0.5,
              ease: "power2.out",
            });
            gsap.to(".card", {
              borderRadius: "0px",
              duration: 0.5,
              ease: "power2.out",
              onComplete: () => {
                gsap.set("#card-1", {
                  borderTopLeftRadius: "12px",
                  borderBottomLeftRadius: "12px",
                });
                gsap.set("#card-3", {
                  borderTopRightRadius: "12px",
                  borderBottomRightRadius: "12px",
                });
              },
            });
          }

          // --------------------------
          // PHASE 3
          // --------------------------
          if (progress > 0.7 && !isFlipAnimDone) {
            isFlipAnimDone = true;

            gsap.to(".card", {
              rotateY: 180,
              stagger: 0.1,
              duration: 1.2,
              ease: "power3.out",
            });
            gsap.to("#card-1", {
              y: 40,
              rotateZ: -3,
              duration: 1.2,
              delay: 0.1,
              ease: "power3.out",
            });
            gsap.to("#card-3", {
              y: 40,
              rotateZ: 3,
              duration: 1.2,
              delay: 0.1,
              ease: "power3.out",
            });
          } else if (progress < 0.7 && isFlipAnimDone) {
            isFlipAnimDone = false;

            gsap.to(".card", {
              rotateY: 0,
              stagger: { each: 0.1, from: "end" },
              duration: 1.2,
              ease: "power3.out",
            });
            gsap.to("#card-1", {
              y: 0,
              rotateZ: 0,
              duration: 1.2,
              ease: "power3.out",
            });
            gsap.to("#card-3", {
              y: 0,
              rotateZ: 0,
              duration: 1.2,
              ease: "power3.out",
            });
          }
        },
      });
    });
  }

  initAnimation();
  window.addEventListener("resize", () => ScrollTrigger.refresh());
});


