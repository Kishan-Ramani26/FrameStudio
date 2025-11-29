//   document.addEventListener("DOMContentLoaded", () => {

//             const lenis = new Lenis();
//             function raf(time) {
//                 lenis.raf(time);
//                 requestAnimationFrame(raf);
//             }
//             requestAnimationFrame(raf);

//             gsap.registerPlugin(ScrollTrigger);

//             let isGapAnimDone = false;
//             let isFlipAnimDone = false;

//             function mapRange(inMin, inMax, outMin, outMax, value) {
//                 return outMin + (value - inMin) * (outMax - outMin) / (inMax - inMin);
//             }

//             function initAnimation() {
//                 let mm = gsap.matchMedia();

//                 mm.add("(min-width: 769px)", () => {

//                     ScrollTrigger.create({
//                         trigger: ".sticky-section",
//                         start: "top top",
//                         end: "+=400%",
//                         pin: true,
//                         scrub: 1,
//                         onUpdate: (self) => {
//                             const progress = self.progress;

//                             // PHASE 1
//                             if (progress <= 0.25) {
//                                 const t = progress / 0.25;
//                                 const newWidth = gsap.utils.interpolate(30, 80, t);
//                                 gsap.set(".card-container", { width: `${newWidth}%` });

//                                 const opacity = gsap.utils.clamp(0, 1, mapRange(0.05, 0.25, 0, 1, progress));
//                                 const yPos = gsap.utils.clamp(0, 50, mapRange(0.05, 0.25, 50, 0, progress));
//                                 gsap.set(".sticky-header", { opacity: opacity, y: yPos });
//                             }
//                             else {
//                                 gsap.set(".card-container", { width: "80%" });
//                                 gsap.set(".sticky-header", { opacity: 1, y: 0 });
//                             }

//                             // PHASE 2
//                             if (progress > 0.35 && !isGapAnimDone) {
//                                 isGapAnimDone = true;
//                                 gsap.to(".card-container", { gap: "2rem", duration: 0.5, ease: "power2.out" });
//                                 gsap.to(".card", { borderRadius: "15px", duration: 0.5, ease: "power2.out" });
//                             }
//                             else if (progress < 0.35 && isGapAnimDone) {
//                                 isGapAnimDone = false;
//                                 gsap.to(".card-container", { gap: "0rem", duration: 0.5, ease: "power2.out" });
//                                 gsap.to(".card", {
//                                     borderRadius: "0px",
//                                     duration: 0.5,
//                                     ease: "power2.out",
//                                     onComplete: () => {
//                                         gsap.set("#card-1", { borderTopLeftRadius: "12px", borderBottomLeftRadius: "12px" });
//                                         gsap.set("#card-3", { borderTopRightRadius: "12px", borderBottomRightRadius: "12px" });
//                                     }
//                                 });
//                             }

//                             // PHASE 3
//                             if (progress > 0.70 && !isFlipAnimDone) {
//                                 isFlipAnimDone = true;
//                                 gsap.to(".card", { rotateY: 180, stagger: 0.1, duration: 1.2, ease: "power3.out" });
//                                 gsap.to("#card-1", { y: 40, rotateZ: -3, duration: 1.2, delay: 0.1, ease: "power3.out" });
//                                 gsap.to("#card-3", { y: 40, rotateZ: 3, duration: 1.2, delay: 0.1, ease: "power3.out" });
//                             }
//                             else if (progress < 0.70 && isFlipAnimDone) {
//                                 isFlipAnimDone = false;
//                                 gsap.to(".card", { rotateY: 0, stagger: { each: 0.1, from: "end" }, duration: 1.2, ease: "power3.out" });
//                                 gsap.to("#card-1", { y: 0, rotateZ: 0, duration: 1.2, ease: "power3.out" });
//                                 gsap.to("#card-3", { y: 0, rotateZ: 0, duration: 1.2, ease: "power3.out" });
//                             }
//                         }
//                     });
//                 });
//             }

//             initAnimation();
//             window.addEventListener("resize", () => ScrollTrigger.refresh());
//         });

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

            // Sticky header animation removed: keep header static
            gsap.set(".sticky-header", { opacity: 1, y: 0 });
          } else {
            gsap.set(".card-container", { width: "80%" });
            gsap.set(".sticky-header", { opacity: 1, y: 0 });
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
