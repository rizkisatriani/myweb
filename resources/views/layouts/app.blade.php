<!DOCTYPE html>
 <html lang="en">
<head>
    <link rel="canonical" href="https://toolsborg.com/" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toolsborg Tools Online Center</title>

    <!-- Meta SEO -->
    <meta name="title" content="Toolsborg Tools Online Center">
    <meta name="description" content="Toolsborg Tools Online Center.">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Themesberg">

    <!-- Social media share -->
    <meta property="og:title" content=Landwind - Tailwind CSS Landing Page>
    <meta property="og:site_name" content="Toolsborg Tools Online Center">
    <meta property="og:url" content=https://toolsborg.com/>
    <meta property="og:description" content="Toolsborg Tools Online Center">
    <meta property="og:type" content="">
    <meta property="og:image" content=https://themesberg.s3.us-east-2.amazonaws.com/public/github/landwind/og-image.png>
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@themesberg" />
    <meta name="twitter:creator" content="@themesberg" />

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="<?= asset('css/output.css'); ?>">
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <meta name="google-site-verification" content="-dM_qQnrtpcnhZSfeDBgaavV4RQt8DkPuVJV0BvEHWs" />
</head>
<body>
    @include('components.topnav') <!-- Navigasi -->
 
        @yield('content') <!-- Tempat konten utama --> 

    @include('components.footer') <!-- Footer -->
</body>
</html>