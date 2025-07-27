<!DOCTYPE html>
 <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toolsborg | {{ $title }}</title>

    <!-- Meta SEO -->
    <meta name="title" content="{{ $title }}">
    <meta name="description" content="{{ $subtitle }}">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
    <meta name="author" content="Toolsborg">

    <!-- Social media share -->
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:site_name" content=Toolsborg>
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ $subtitle }}">
    <meta property="og:type" content="">
    <meta property="og:image" content=https://themesberg.s3.us-east-2.amazonaws.com/public/github/landwind/og-image.png>
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@themesberg" />
    <meta name="twitter:creator" content="@themesberg" />
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
</head>
<body>
    @include('components.topnav') <!-- Navigasi -->
 
        @yield('content') <!-- Tempat konten utama --> 

    @include('components.footer') <!-- Footer -->
</body>
</html>