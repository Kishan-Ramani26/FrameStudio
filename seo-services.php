<?php
$seo = [
  'type'         => 'service',
  'service_name' => 'Technical SEO Services',
  'title'        => 'Technical SEO Agency India | Organic Growth | Frame Studio',
  'description'  => 'Frame Studio is a results-driven technical SEO agency in India. We offer technical SEO audits, on-page optimization, Core Web Vitals, local SEO, & link building.',
  'keywords'     => 'technical SEO agency India, SEO services India, SEO company Rajkot, on-page SEO optimization, Core Web Vitals service, local SEO India, Generative Engine Optimization',
  'path'         => '/seo-services',
  'breadcrumb'   => [['Home', '/'], ['Services', '/services'], ['SEO Services', '/seo-services']],
  'answer'       => 'Frame Studio is a technical SEO agency in India specializing in Core Web Vitals engineering, connected Schema.org architecture, on-page optimization, and AI Generative Engine Optimization (GEO).',
  'faqs'         => [
    ['What is Generative Engine Optimization (GEO)?', 'GEO optimizes your brand entity and content architecture so modern AI search engines like ChatGPT, Perplexity, and Claude cite your business in AI-generated answers.'],
    ['How fast can I see SEO results?', 'Technical fixes (schema, Core Web Vitals, indexation) typically show crawling and ranking improvements within 2 to 6 weeks, with compound organic traffic growth following over 3 to 6 months.'],
  ],
];
include 'header.php';
?>

<div class="page-wrapper" data-barba="container" data-barba-namespace="seo">

  <section class="about-hero" style="padding-top: 140px; padding-bottom: 60px;">
    <div class="container">
      <div class="about-hero-wrap">
        <div class="hero-top-wrap">
          <div class="hero-01-text-wrap">
            <h1 class="h1">TECHNICAL SEO AGENCY <span class="text-primary">IN INDIA</span></h1>
            <p class="paragraph-03 text-gray-color" style="max-width: 750px; margin-top: 20px;">
              Dominate organic Google rankings and drive targeted buyer traffic. We combine technical SEO engineering, schema architecture, Core Web Vitals optimization, and high-intent content strategy.
            </p>
            <div style="margin-top: 30px;">
              <a href="/contact-us" class="button-02 w-inline-block">
                <div class="button-text-wrapper"><div class="paragraph-02 text-black">Request Free SEO Audit →</div></div>
                <div class="hover-color bg-primary-color"></div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section style="padding: 80px 0; background: #080808;">
    <div class="container">
      <h2 class="h2" style="text-align: center; margin-bottom: 50px;">DATA-DRIVEN <span class="text-primary">SEO SERVICES</span></h2>
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
        
        <div style="background: #111; border: 1px solid #222; border-radius: 12px; padding: 30px;">
          <h3 class="h4" style="color: var(--color--primary-color); margin-bottom: 12px;">Technical SEO Audits</h3>
          <p class="paragraph-03 text-gray-color">Deep-dive crawl analysis resolving canonical conflicts, indexing bottlenecks, duplicate content, 404 loops, and XML sitemap errors.</p>
        </div>

        <div style="background: #111; border: 1px solid #222; border-radius: 12px; padding: 30px;">
          <h3 class="h4" style="color: var(--color--primary-color); margin-bottom: 12px;">Core Web Vitals & Speed</h3>
          <p class="paragraph-03 text-gray-color">Optimization of LCP, INP, and CLS scores to align 100% with Google's Page Experience ranking algorithms.</p>
        </div>

        <div style="background: #111; border: 1px solid #222; border-radius: 12px; padding: 30px;">
          <h3 class="h4" style="color: var(--color--primary-color); margin-bottom: 12px;">Schema & Rich Snippets</h3>
          <p class="paragraph-03 text-gray-color">Implementation of valid JSON-LD structured data (Organization, Service, FAQPage, Article, Review) to capture eye-catching Google rich snippets.</p>
        </div>

      </div>
    </div>
  </section>

  <section class="cta-v1">
    <div class="container">
      <div class="cta-v1-wrap">
        <div class="cta-v1-text-wrap">
          <h2 class="h1 align-center">BOOST YOUR ORGANIC GOOGLE RANKINGS</h2>
        </div>
        <div class="cta-v1-button-wrap">
          <a href="/contact-us" class="button-01 cta-button w-inline-block">
            <div class="button-text-wrapper"><div class="paragraph-02 text-black">Claim Your SEO Growth Plan</div></div>
          </a>
        </div>
      </div>
    </div>
  </section>

</div>

<?php include 'footer.php'; ?>
