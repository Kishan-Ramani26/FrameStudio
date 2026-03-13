<?php
// Dynamic SEO Variables - set these before including header.php
$site_url = "https://framestudio.in";
$page_title = isset($page_title) ? $page_title : "Frame Studio | Creative Web Design & Development Agency in India";
$page_description = isset($page_description) ? $page_description : "Frame Studio is a premium web design agency offering custom website development, UI/UX design, branding, and digital experiences. Transform your brand with stunning websites that convert.";
$page_keywords = isset($page_keywords) ? $page_keywords : "web design agency, web development, UI UX design, creative agency, website design India, custom website development, branding agency, digital agency, Frame Studio";
$canonical_url = isset($canonical_url) ? $canonical_url : $site_url . "/";
$og_image = isset($og_image) ? $og_image : $site_url . "/images/og-image.jpg";
$wf_site_id = isset($wf_site_id) ? $wf_site_id : "6845c0d2aeb4f8e6515d4444";
$wf_page_id = isset($wf_page_id) ? $wf_page_id : "6845c0d2aeb4f8e6515d4443";
?>
<!DOCTYPE html>
<html data-wf-page="<?php echo htmlspecialchars($wf_page_id); ?>" data-wf-site="<?php echo htmlspecialchars($wf_site_id); ?>" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  
  <!-- Primary SEO Meta Tags -->
  <title><?php echo htmlspecialchars($page_title); ?></title>
  <meta name="title" content="<?php echo htmlspecialchars($page_title); ?>" />
  <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>" />
  <meta name="keywords" content="<?php echo htmlspecialchars($page_keywords); ?>" />
  <meta name="author" content="Frame Studio" />
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
  <meta name="googlebot" content="index, follow" />
  <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url); ?>" />
  
  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website" />
  <meta property="og:url" content="<?php echo htmlspecialchars($canonical_url); ?>" />
  <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>" />
  <meta property="og:description" content="<?php echo htmlspecialchars($page_description); ?>" />
  <meta property="og:image" content="<?php echo htmlspecialchars($og_image); ?>" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:site_name" content="Frame Studio" />
  <meta property="og:locale" content="en_US" />

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:url" content="<?php echo htmlspecialchars($canonical_url); ?>" />
  <meta name="twitter:title" content="<?php echo htmlspecialchars($page_title); ?>" />
  <meta name="twitter:description" content="<?php echo htmlspecialchars($page_description); ?>" />
  <meta name="twitter:image" content="<?php echo htmlspecialchars($og_image); ?>" />
  <meta name="twitter:creator" content="@framestudio" />

  <!-- Additional SEO Meta -->
  <meta name="theme-color" content="#00a8ff" />
  <meta name="msapplication-TileColor" content="#00a8ff" />
  <meta name="format-detection" content="telephone=no" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  
  <!-- Geo Tags (India) -->
  <meta name="geo.region" content="IN" />
  <meta name="geo.placename" content="India" />
  
  <!-- DNS Prefetch & Preconnect for faster external resources -->
  <link rel="dns-prefetch" href="//cdn.jsdelivr.net" />
  <link rel="dns-prefetch" href="//unpkg.com" />
  <link rel="dns-prefetch" href="//www.google-analytics.com" />
  <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin />
  <link rel="preconnect" href="https://unpkg.com" crossorigin />

  <!-- Preload critical resources -->
  <link rel="preload" as="style" href="css/style.css" />
  <link rel="preload" as="image" href="images/hero-2001-20bg-poster-00001.jpg" type="image/jpeg" fetchpriority="high" />
  <link rel="preload" as="font" href="images/dmsans-regular.ttf" type="font/ttf" crossorigin />
  <link rel="preload" as="font" href="images/dmsans-bold.ttf" type="font/ttf" crossorigin />

  <!-- JSON-LD Structured Data for Organization -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Frame Studio",
    "url": "https://framestudio.in",
    "logo": "https://framestudio.in/images/Frame-Studio Logo.png",
    "description": "Frame Studio is a premium web design agency offering custom website development, UI/UX design, branding, and digital experiences.",
    "address": {
      "@type": "PostalAddress",
      "addressCountry": "IN"
    },
    "sameAs": [
      "https://www.instagram.com/framestudio",
      "https://www.linkedin.com/company/framestudio",
      "https://dribbble.com/framestudio",
      "https://www.behance.net/framestudio",
      "https://twitter.com/framestudio"
    ],
    "contactPoint": {
      "@type": "ContactPoint",
      "contactType": "customer service",
      "url": "https://framestudio.in/contact-us.php"
    }
  }
  </script>

  <!-- JSON-LD Structured Data for WebSite (enables sitelinks search) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "Frame Studio",
    "url": "https://framestudio.in",
    "potentialAction": {
      "@type": "SearchAction",
      "target": "https://framestudio.in/?s={search_term_string}",
      "query-input": "required name=search_term_string"
    }
  }
  </script>

  <!-- JSON-LD for Local Business / Professional Service -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "ProfessionalService",
    "name": "Frame Studio",
    "image": "https://framestudio.in/images/Frame-Studio Logo.png",
    "url": "https://framestudio.in",
    "priceRange": "$$",
    "serviceType": ["Web Design", "Web Development", "UI/UX Design", "Branding", "Digital Marketing"],
    "areaServed": {
      "@type": "Country",
      "name": "Worldwide"
    },
    "hasOfferCatalog": {
      "@type": "OfferCatalog",
      "name": "Web Design Services",
      "itemListElement": [
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "Custom Website Design"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "UI/UX Design"
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "Brand Identity Design"
          }
        }
      ]
    }
  }
  </script>

  <!-- Critical CSS for above-the-fold content -->
  <style>
    :root{--color--primary-color:#00a8ff;--100:100%}
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'DM Sans',sans-serif;background:#000;color:#fff;overflow-x:hidden}
    .navbar-container{position:fixed;top:0;left:0;right:0;z-index:100}
    .home-hero{height:100vh;position:relative}
    .hero-01{height:100vh;display:flex;align-items:center;justify-content:center}
    .hero-background-video{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:-1}
    .h1{font-size:clamp(2.5rem,6vw,5rem);font-weight:700;line-height:1.1}
    .text-primary{color:var(--color--primary-color)}
    .page-wrapper{opacity:1}
  </style>

  <!-- Main stylesheet - must load blocking for preloader animation -->
  <link href="css/style.css" rel="stylesheet" type="text/css" />

  <!-- Lenis smooth scroll - defer to not block render -->
  <script defer src="https://unpkg.com/@studio-freight/lenis@1.0.41/dist/lenis.min.js"></script>
  
  <!-- Webflow touch detection - minimal inline -->
  <script>!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
  
  <link href="images/favicon.png" rel="shortcut icon" type="image/png" />
  <link href="images/app-icon.png" rel="apple-touch-icon" />
</head>

<body>
  <div data-animation="default" data-collapse="medium" data-duration="600" data-easing="ease" data-easing2="ease"
    role="banner" class="navbar-container w-nav">
    <div data-w-id="0b18129c-3348-a3fe-a5ce-e30bedbd54eb" class="navbar-container-wrap">
      <div class="navbar-wrapper">
        <a href="index.php" aria-current="page" class="navbar-brand w-nav-brand w--current">
          <img decoding="async" src="images/Frame-Studio Logo.png" alt="Frame Studio Logo" class="navbar-brand-logo" />
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
                  <a href="index.php" aria-current="page" class="nav-link-text w--current">Home</a>
                </li>
                <li class="nav-item">
                  <a href="about.php" class="nav-link-text">About</a>
                </li>
                <li class="nav-item">
                  <a href="project.php" class="nav-link-text">Projects</a>
                </li>
                <li class="nav-item">
                  <a href="pricing.php" class="nav-link-text">Pricing</a>
                </li>
                <li class="nav-item hide">
                  <a href="services.php" class="nav-link-text">Service</a>
                </li>
                <li class="nav-item">
                  <a href="blog.php" class="nav-link-text">Blog</a>
                </li>
                <li class="mobile-margin-top-12">
                  <div class="nav-button-wrapper mobile">
                    <a data-w-id="0b18129c-3348-a3fe-a5ce-e30bedbd5502" href="contact-us.php"
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
        <svg style="display: none">
          <filter id="glass-distortion" x="0%" y="0%" width="100%" height="100%"
            filterUnits="objectBoundingBox">
            <feTurbulence type="fractalNoise" baseFrequency="0.01 0.01" numOctaves="1" seed="5"
              result="turbulence" />
            <!-- Seeds: 14, 17,  -->

            <feComponentTransfer in="turbulence" result="mapped">
              <feFuncR type="gamma" amplitude="1" exponent="10" offset="0.5" />
              <feFuncG type="gamma" amplitude="0" exponent="1" offset="0" />
              <feFuncB type="gamma" amplitude="0" exponent="1" offset="0.5" />
            </feComponentTransfer>

            <feGaussianBlur in="turbulence" stdDeviation="3" result="softMap" />

            <feSpecularLighting in="softMap" surfaceScale="5" specularConstant="1" specularExponent="100"
              lighting-color="white" result="specLight">
              <fePointLight x="-200" y="-200" z="300" />
            </feSpecularLighting>

            <feComposite in="specLight" operator="arithmetic" k1="0" k2="1" k3="1" k4="0"
              result="litImage" />

            <feDisplacementMap in="SourceGraphic" in2="softMap" scale="150" xChannelSelector="R"
              yChannelSelector="G" />
          </filter>
        </svg>


        <div class="nav-right-wrap">
          <div class="nav-right">            
            <div class="nav-button-wrapper">
              <a data-w-id="0b18129c-3348-a3fe-a5ce-e30bedbd5546"
                href="contact-us.php" class="button-04 nav w-inline-block">
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
        <img
          decoding="async"
          loading="lazy"
          fetchpriority="low"
          src="images/Frame-Studio-bw-Logo.png"
          alt="">
      </div>
      <div class="image-wrapper">
        <img
          decoding="async"
          loading="lazy"
          fetchpriority="low"
          src="images/Frame-Studio-Black-Logo.png"
          alt="">
      </div>
      <div class="image-wrapper">
        <img
          decoding="async"
          loading="lazy"
          fetchpriority="low"
          src="images/Frame-Studio Logo.png"
          alt="">
      </div>
    </div>
  </div>

  <!-- Page Transition Overlay (outside barba wrapper so it persists) -->
  <div id="transition-overlay" class="transition-overlay" aria-hidden="true">
    <svg
      width="100%"
      height="100%"
      viewBox="0 0 1316 664"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
      class="transition-svg"
      preserveAspectRatio="xMidYMid slice"
    >
      <path
        id="transition-path"
        class="transition-path"
        pathLength="1"
        d="M13.4746 291.27C13.4746 291.27 100.646 -18.6724 255.617 16.8418C410.588 52.356 61.0296 431.197 233.017 546.326C431.659 679.299 444.494 21.0125 652.73 100.784C860.967 180.556 468.663 430.709 617.216 546.326C765.769 661.944 819.097 48.2722 988.501 120.156C1174.21 198.957 809.424 543.841 988.501 636.726C1189.37 740.915 1301.67 149.213 1301.67 149.213"
        stroke="#00a8ff"
        stroke-linecap="round"
        stroke-linejoin="round"
      />
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