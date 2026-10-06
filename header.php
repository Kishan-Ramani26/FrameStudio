<?php
// Dynamic SEO Variables - set these before including header.php
$site_url = "https://framestudio.in";
$page_title = isset($page_title) ? $page_title : "Frame Studio | Premium Web Design & Development Agency in Rajkot, India";
$page_description = isset($page_description) ? $page_description : "Frame Studio is a premium web design and development agency based in Rajkot, India, offering custom website development, UI/UX design, branding, and e-commerce solutions. Transform your digital presence today.";
$page_keywords = isset($page_keywords) ? $page_keywords : "web design agency Rajkot, web development agency Rajkot, web agency India, UI UX design, creative agency Rajkot, custom website development, branding agency, e-commerce web agency, Frame Studio";
$canonical_url = isset($canonical_url) ? $canonical_url : $site_url . "/";
$og_image = isset($og_image) ? $og_image : $site_url . "/images/frame-studio-og.jpg";
$wf_site_id = isset($wf_site_id) ? $wf_site_id : "6845c0d2aeb4f8e6515d4444";
$wf_page_id = isset($wf_page_id) ? $wf_page_id : "6845c0d2aeb4f8e6515d4443";
?>
<!DOCTYPE html>
<html data-wf-page="<?php echo htmlspecialchars($wf_page_id); ?>"
    data-wf-site="<?php echo htmlspecialchars($wf_site_id); ?>" lang="en">

<head>
    <base href="/">
    <?php include __DIR__ . '/seo-head.php'; ?>

    <!-- Preload critical resources -->
    <link rel="preload" as="style" href="css/style.css" />
    <link rel="preload" as="image" href="images/hero-2001-20bg-poster-00001.jpg" type="image/jpeg"
        fetchpriority="high" />
    <link rel="preload" as="font" href="images/dmsans-regular.ttf" type="font/ttf" crossorigin />
    <link rel="preload" as="font" href="images/dmsans-bold.ttf" type="font/ttf" crossorigin />

    <!-- Critical CSS for above-the-fold content -->
    <style>
    :root {
        --color--primary-color: #00a8ff;
        --100: 100%
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0
    }

    body {
        font-family: 'DM Sans', sans-serif;
        background: #000;
        color: #fff;
        overflow-x: hidden
    }

    .navbar-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 100
    }

    .home-hero {
        height: 100vh;
        position: relative
    }

    .hero-01 {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center
    }

    .hero-background-video {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -1
    }

    .h1 {
        font-size: clamp(2.5rem, 6vw, 5rem);
        font-weight: 700;
        line-height: 1.1
    }

    .text-primary {
        color: var(--color--primary-color)
    }

    .page-wrapper {
        opacity: 1
    }
    </style>

    <link href="css/style.css?v=<?php echo filemtime(__DIR__ . '/css/style.css'); ?>" rel="stylesheet"
        type="text/css" />

    <!-- Lenis smooth scroll - defer to not block render -->
    <script defer src="https://unpkg.com/@studio-freight/lenis@1.0.41/dist/lenis.min.js"></script>

    <!-- Webflow touch detection - minimal inline -->
    <script>
    ! function(o, c) {
        var n = c.documentElement,
            t = " w-mod-";
        n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n
            .className += t + "touch")
    }(window, document);
    </script>

    <link href="images/favicon.png" rel="shortcut icon" type="image/png" />
    <link href="images/app-icon.png" rel="apple-touch-icon" />
</head>

<body>
    <div data-animation="default" data-collapse="medium" data-duration="600" data-easing="ease" data-easing2="ease"
        role="banner" class="navbar-container w-nav">
        <div data-w-id="0b18129c-3348-a3fe-a5ce-e30bedbd54eb" class="navbar-container-wrap">
            <div class="navbar-wrapper">
                <a href="/" aria-current="page" class="navbar-brand w-nav-brand w--current">
                    <img decoding="async" src="images/Frame-Studio Logo.png" alt="Frame Studio Logo"
                        class="navbar-brand-logo" />
                </a>

                <div class="liquidGlass-wrapper">
                    <div class="liquidGlass-effect"></div>
                    <div class="liquidGlass-tint">
                    </div>
                    <div class="liquidGlass-shine"></div>
                    <div class="liquidGlass-text">
                        <nav role="navigation" class="nav-menu-wrapper w-nav-menu">
                            <ul role="list" class="nav-menus w-list-unstyled">
                                <li class="nav-item">
                                    <a href="/" aria-current="page" class="nav-link-text w--current">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a href="/about" class="nav-link-text">About</a>
                                </li>
                                <li class="nav-item">
                                    <a href="/project" class="nav-link-text">Projects</a>
                                </li>
                                <li class="nav-item">
                                    <a href="/pricing" class="nav-link-text">Pricing</a>
                                </li>
                                <li class="nav-item">
                                    <a href="/services" class="nav-link-text">Services</a>
                                </li>
                                <li class="nav-item">
                                    <a href="/blog" class="nav-link-text">Blog</a>
                                </li>
                                <li class="mobile-margin-top-12">
                                    <div class="nav-button-wrapper mobile">
                                        <a data-w-id="0b18129c-3348-a3fe-a5ce-e30bedbd5502" href="/contact-us"
                                            class="button-04 nav w-inline-block">
                                            <div class="button-text-wrapper">
                                                <div class="paragraph-02">Let’s Contact</div>
                                                <div class="paragraph-02 text-black">Let’s Contact</div>
                                            </div>
                                            <div class="hover-color bg-primary-color"></div>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <svg width="0" height="0" style="position:absolute" aria-hidden="true">
                    <filter id="glass-distortion" x="0%" y="0%" width="100%" height="100%">
                        <feTurbulence type="fractalNoise" baseFrequency="0.01 0.01" numOctaves="1" seed="5"
                            result="turbulence" />
                        <feGaussianBlur in="turbulence" stdDeviation="3" result="softMap" />
                        <feDisplacementMap in="SourceGraphic" in2="softMap" scale="40" xChannelSelector="R"
                            yChannelSelector="G" />
                    </filter>
                </svg>

                <div class="nav-right-wrap">
                    <div class="nav-right">
                        <div class="nav-button-wrapper">
                            <a data-w-id="0b18129c-3348-a3fe-a5ce-e30bedbd5546" href="/contact-us"
                                class="button-04 nav w-inline-block">
                                <div class="button-text-wrapper">
                                    <div class="paragraph-02">Let’s Contact</div>
                                    <div class="paragraph-02 text-black">Let’s Contact</div>
                                </div>
                                <div class="hover-color bg-primary-color"></div>
                            </a>
                        </div>
                    </div>
                    <div data-w-id="0b18129c-3348-a3fe-a5ce-e30bedbd554d" class="menu-button w-nav-button">
                        <div data-is-ix2-target="1" class="hamburger-menu"
                            data-w-id="0b18129c-3348-a3fe-a5ce-e30bedbd554e" data-animation-type="lottie"
                            data-src="js/navbar-20black-20json.json" data-loop="0" data-direction="1" data-autoplay="0"
                            data-renderer="svg" data-default-duration="0" data-duration="0.9666666666666667"
                            data-ix2-initial-state="0"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
  // Preloader only shows on first visit (sessionStorage check done in JS)
  // We always render the HTML but JS will hide it if already seen
  ?>
    <div class="preloader" data-enabled="true">
        <div class="progress-bar"></div>

        <div class="preloader-header">
            <span id="logo-text">FRAMESTUDIO</span>
        </div>

        <div class="preloader-images">
            <div class="image-wrapper"></div>
            <div class="image-wrapper">
                <img decoding="async" loading="lazy" fetchpriority="low" src="images/Frame-Studio-bw-Logo.png" alt="">
            </div>
            <div class="image-wrapper">
                <img decoding="async" loading="lazy" fetchpriority="low" src="images/Frame-Studio-Black-Logo.png"
                    alt="">
            </div>
            <div class="image-wrapper">
                <img decoding="async" loading="lazy" fetchpriority="low" src="images/Frame-Studio Logo.png" alt="">
            </div>
        </div>
    </div>

    <!-- Page Transition Overlay (outside barba wrapper so it persists) -->
    <div id="transition-overlay" class="transition-overlay" aria-hidden="true">
        <svg width="100%" height="100%" viewBox="0 0 1316 664" fill="none" xmlns="http://www.w3.org/2000/svg"
            class="transition-svg" preserveAspectRatio="xMidYMid slice">
            <path id="transition-path" class="transition-path" pathLength="1"
                d="M13.4746 291.27C13.4746 291.27 100.646 -18.6724 255.617 16.8418C410.588 52.356 61.0296 431.197 233.017 546.326C431.659 679.299 444.494 21.0125 652.73 100.784C860.967 180.556 468.663 430.709 617.216 546.326C765.769 661.944 819.097 48.2722 988.501 120.156C1174.21 198.957 809.424 543.841 988.501 636.726C1189.37 740.915 1301.67 149.213 1301.67 149.213"
                stroke="#00a8ff" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </div>

    <script>
    // Disable preloader if user has already seen it this session
    if (sessionStorage.getItem('preloaderShown')) {
        var pl = document.querySelector('.preloader');
        if (pl) pl.setAttribute('data-enabled', 'false');
    }
    </script>

    <!-- Barba.js wrapper for page transitions -->
    <div data-barba="wrapper">