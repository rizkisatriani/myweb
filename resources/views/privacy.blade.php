@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<section class="bg-white">
    <div class="max-w-screen-md mx-auto px-4 py-12">
        <div class="mb-4 text-sm text-gray-600 mt-6">
            <a href="{{ url('/') }}" class="text-gray-500 hover:text-purple-600">← Back to Home</a>
        </div>
        <h1 class="text-3xl font-bold mb-4">Privacy Policy</h1>
        <p class="text-gray-500 text-sm mb-4">Last updated on {{ now()->format('F j, Y') }}</p>
        
        <article class="prose max-w-none">
            <h2>1. Introduction</h2>
            <p>This Privacy Policy outlines how we collect, use, and protect your personal data in accordance with the General Data Protection Regulation (GDPR).</p>

            <h2>2. Data Controller</h2>
            <p>The data controller responsible for your personal data is:</p>
            <p>
                Website Owner<br>
                Toolsborg<br>
                Indonesia<br>
                Email: <a href="mailto:agungrizki0@gmail.com">agungrizki0@gmail.com</a>
            </p>

            <h2>3. What Personal Data We Collect</h2>
            <ul>
                <li>Name and email address (via contact forms, comments, newsletter)</li>
                <li>IP address and browser information (via cookies and analytics)</li>
                <li>Any information you voluntarily submit</li>
            </ul>

            <h2>4. Legal Basis for Processing</h2>
            <p>We process your personal data on the following legal bases:</p>
            <ul>
                <li>Consent (e.g., when you subscribe to our newsletter)</li>
                <li>Legitimate interest (e.g., to improve our website)</li>
                <li>Legal obligation (e.g., if required by law)</li>
            </ul>

            <h2>5. How We Use Your Data</h2>
            <p>We use your data to:</p>
            <ul>
                <li>Respond to inquiries or comments</li>
                <li>Send newsletters or updates (if subscribed)</li>
                <li>Analyze website traffic and usage</li>
            </ul>

            <h2>6. Data Retention</h2>
            <p>We retain your personal data only as long as necessary for the purposes it was collected, or as required by applicable laws.</p>

            <h2>7. Cookies and Tracking</h2>
            <p>We use cookies to enhance user experience and analyze website usage. By using our site, you consent to our use of cookies. You may disable cookies in your browser settings.</p>

            <h2>8. Your Rights Under GDPR</h2>
            <p>As a data subject under GDPR, you have the right to:</p>
            <ul>
                <li>Access your personal data</li>
                <li>Rectify inaccurate data</li>
                <li>Request erasure (“right to be forgotten”)</li>
                <li>Restrict or object to processing</li>
                <li>Data portability</li>
                <li>Withdraw consent at any time (where applicable)</li>
                <li>Lodge a complaint with a supervisory authority</li>
            </ul>

            <h2>9. Third-Party Services</h2>
            <p>We may use third-party services (e.g., analytics or email services). These services may collect data as described in their respective privacy policies.</p>

            <h2>10. Data Security</h2>
            <p>We take appropriate technical and organizational measures to protect your personal data from unauthorized access, disclosure, or destruction.</p>

            <h2>11. International Data Transfers</h2>
            <p>If we transfer your data outside the European Economic Area (EEA), we ensure adequate protection in accordance with GDPR standards.</p>

            <h2>12. Changes to This Policy</h2>
            <p>We may update this Privacy Policy from time to time. The latest version will always be available on this page with the date of last update.</p>

            <h2>13. Contact Us</h2>
            <p>If you have any questions or wish to exercise your GDPR rights, please contact us at:</p>
            <p><a href="mailto:agungrizki0@gmail.com">agungrizki0@gmail.com</a></p>
        </article>
    </div>
</section>
@endsection
