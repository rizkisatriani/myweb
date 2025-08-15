<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toolsborg | {{ $title }}</title>

    <!-- Meta SEO -->
    <meta name="title" content="{{ $title }} | Toolsborg">
    <meta name="description" content="{{ $subtitle }}">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="author" content="Toolsborg">

    <!-- Social media share -->
     <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:site_name" content="Toolsborg">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ $subtitle }}">
    <meta property="og:type" content="">
    <meta property="og:image" content="https://toolsborg.com/img/ilustration_1.jpg">
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="Toolsborg" />
    <meta name="twitter:creator" content="Toolsborg" />
    <meta name="google-adsense-account" content="ca-pub-9168454602694889">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/logo.svg">
    <link rel="icon" type="image/png" sizes="16x16" href="/logo.svg">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="<?= asset('css/output.css'); ?>">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta name="language" content="{{ app()->getLocale()}}">
    <meta name="robots" content="index, follow">
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <meta name="google-site-verification" content="-dM_qQnrtpcnhZSfeDBgaavV4RQt8DkPuVJV0BvEHWs" />
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9168454602694889"
        crossorigin="anonymous"></script>
    <!-- Event snippet for Website sale conversion page -->
    <script>
        gtag('event', 'conversion', {
            'send_to': 'AW-872504487/vHuNCLne-8cDEKe5haAD',
            'transaction_id': ''
        });
    </script>
    
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-1RKJYCN6P1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-1RKJYCN6P1');
    </script>  
     @stack('json-ld')
</head>     
<body>
    @include('components.topnav') <!-- Navigasi -->

    @yield('content') <!-- Tempat konten utama -->

    @include('components.footer') <!-- Footer -->
    <!-- Cookie Consent Banner -->
    <div id="cookie-consent"
     class="fixed inset-0 bg-black bg-opacity-40 flex justify-center z-50 transition-opacity duration-300 items-end pb-8 mb-8 hidden">
    <div class="max-w-sm w-full rounded-xl p-6 shadow-xl text-center relative bg-gray-200 shadow-lg max-w-screen-md">
        <h2 class="text-lg font-semibold mb-3 text-gray-800">We value your privacy</h2>
        <p class="text-sm text-gray-600 mb-4">
            We use cookies to improve your experience. By using our site, you consent to cookies. 
            <a href="/privacy" class="text-purple-600 underline">Learn more</a>.
        </p>
        <button id="accept-cookies"
                class="bg-purple-600 text-white px-5 py-2 rounded hover:bg-purple-700 transition">
            Accept
        </button>
    </div>
</div>

<script>
    window.addEventListener("load", function () {
        const consentModal = document.getElementById("cookie-consent");
        const acceptBtn = document.getElementById("accept-cookies");

        if (!localStorage.getItem("cookie_consent")) {
            consentModal.classList.remove("hidden");
            setTimeout(() => {
                consentModal.classList.remove("opacity-0");
            }, 50);
        } 

        acceptBtn.addEventListener("click", function () {
            localStorage.setItem("cookie_consent", "true");
            consentModal.classList.add("opacity-0");
            setTimeout(() => {
                consentModal.classList.add("hidden");
            }, 300);
        });
    });
</script>
  @stack('scripts')
</body>

</html>