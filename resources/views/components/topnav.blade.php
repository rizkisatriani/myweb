<style>
    /* untuk header fixed: atur offset konten di bawah */
    :root {
        --header-h: 64px;
    }

    /* sesuaikan dengan tinggi sebenarnya */
    body {
        padding-top: var(--header-h);
    }

    /* fallback hover -> keyboard */
    .has-mega:focus-within .mega,
    .has-mega:hover .mega {
        display: block;
    }

    /* jembatan hover 12–16px di atas panel */
    .has-mega .mega::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: -24px;
        height: 64px;
        width: 100%;
    }

    /* kalau panel menutupi seluruh viewport di bawah header */
    .has-mega .mega {
        /* tetap fixed full width */
        position: fixed;
        left: 0;
        right: 0;
        /* top diisi via CSS variable di bawah */
        top: var(--header-bottom, 64px);
        z-index: 50;
    }
</style>

<header class="fixed inset-x-0 top-0 z-50 shadow-lg bg-white dark:bg-gray-900">
    <nav class="border-gray-200">
        <div class="flex items-center justify-between max-w-screen-xl px-4 mx-auto h-16">
            <!-- Brand -->
            <a href="/" class="flex items-center">
                <img src="/images/logo.svg" class="h-6 mr-3 sm:h-9" alt="Toolsborg" />
                <span class="text-xl font-semibold whitespace-nowrap dark:text-white">Toolsborg</span>
            </a>

            <!-- Right: CTA + Mobile toggle -->
            <div class="flex items-center lg:order-2 gap-2">
                <a href="/contact"
                    class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2.5 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800">
                    Contact Us
                </a>

                <!-- Mobile menu button -->
                <button id="nav-toggle"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-600 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-300 dark:hover:bg-gray-800 dark:focus:ring-gray-700"
                    aria-controls="primary-menu"
                    aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- icon burger -->
                    <svg class="w-6 h-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M3 5h14a1 1 0 010 2H3a1 1 0 010-2zm0 5h14a1 1 0 010 2H3a1 1 0 010-2zm0 5h14a1 1 0 010 2H3a1 1 0 010-2z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <!-- Primary menu -->
            <div id="primary-menu"
                class="items-center justify-between hidden w-full lg:flex lg:w-auto lg:order-1">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0 gap-6">
                    <li>
                        <a href="/"
                            class="block py-2 pl-3 pr-4 text-white bg-purple-700 rounded lg:bg-transparent lg:text-purple-700 lg:p-0 dark:text-white"
                            aria-current="page">Home</a>
                    </li>

                    <!-- Tools: megamenu -->
                    <li class="relative has-mega">
                        <button type="button"
                            class="block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 lg:border-0 hover:text-purple-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white"
                            aria-haspopup="true"
                            aria-expanded="false"
                            aria-controls="mega-tools">
                            Tools
                            <i class="bi bi-chevron-down text-gray-700 text-sm"></i>
                        </button>

                        <!-- Megamenu: full width under header -->
                        <div id="mega-tools"
                            class="mega hidden fixed inset-x-0 top-[60px] z-50 pt-0">
                            <div class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 shadow-lg">
                                <div class="max-w-screen-xl mx-auto px-4 py-8">

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                                        <!-- Col 1 -->
                                        <div>
                                            <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Images Tools</h3>
                                            <ul class="space-y-2">
                                                <li><a href="/en/convert-png-to-jpg" class="py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center gap-2">
                                                        <i class="bi bi-filetype-jpg text-gray-500 text-xl"></i>
                                                        Convert PNG To JPG</a></li>
                                                <li><a href="/en/convert-jpg-to-png" class="py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center gap-2">
                                                        <i class="bi bi-filetype-png text-gray-500 text-xl"></i>
                                                        Convert JPG To PNG</a></li>
                                                <li><a href="/en/convert-jpg-to-pdf" class="py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center gap-2">
                                                        <i class="bi bi-file-earmark-pdf text-gray-500 text-xl"></i>
                                                        Convert JPG To PDF</a></li>
                                                <li><a href="/en/convert-png-to-pdf" class="py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center gap-2">
                                                        <i class="bi bi-file-earmark-pdf text-gray-500 text-xl"></i>
                                                        Convert PNG To PDF</a></li>
                                                <li><a href="/en/convert-png-to-webp" class="py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center gap-2">
                                                        <i class="bi bi-images text-gray-500 text-xl"></i>
                                                        Convert PNG To WEBP</a></li>
                                            </ul>
                                        </div>

                                        <!-- Col 2 -->
                                        <div>
                                            <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Document Tools</h3>
                                            <ul class="space-y-2">
                                                <li><a href="/en/convert-word-to-pdf" class="py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center gap-2">
                                                        <i class="bi bi-file-earmark-word text-gray-500 text-xl"></i>
                                                        Convert Word To PDF</a></li>
                                                <li><a href="/en/convert-ppt-to-pdf" class="py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center gap-2">
                                                        <i class="bi bi-filetype-ppt text-gray-500 text-xl"></i>
                                                        Convert PPT / PPTX To PDF</a></li>
                                                <li><a href="/en/pdf/merge" class="py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center gap-2">
                                                        <i class="bi bi-intersect text-gray-500 text-xl"></i>
                                                        Merge PDF files</a></li>
                                                <li><a href="/en/pdf/compress" class="py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center gap-2">
                                                        <i class="bi bi-file-earmark-zip text-gray-500 text-xl"></i>
                                                        Compress PDF Files</a></li>
                                                <li><a href="/en/invoice/create" class="py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center gap-2">
                                                        <i class="bi bi-receipt text-gray-500 text-xl"></i>
                                                        Invoice Generator</a></li>
                                            </ul>
                                        </div>

                                        <!-- Col 3 -->
                                        <div>
                                            <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Qr Code Generator</h3>
                                            <ul class="space-y-2">
                                                <li><a href="/en/qrcode-generator-free" class="py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center gap-2">
                                                        <i class="bi bi-qr-code text-gray-500 text-xl"></i>
                                                        Generate Qr Code for url</a></li>
                                                <li><a href="/en/contact-qrcode-generator-free" class="py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center gap-2">
                                                        <i class="bi bi-qr-code text-gray-500 text-xl"></i>
                                                        Generate Qr Code for contact</a></li>
                                                <li><a href="/en/contact-qrcode-generator-free" class="py-2 px-3 rounded hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center gap-2">
                                                        <i class="bi bi-qr-code text-gray-500 text-xl"></i>
                                                        Generate Qr Code for wifi</a></li>
                                            </ul>
                                        </div>
                                    </div> <!-- grid -->
                                </div> <!-- container -->
                            </div> <!-- panel -->
                        </div> <!-- mega -->
                    </li>

                    <li>
                        <a href="/blogs"
                            class="block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 lg:border-0 hover:text-purple-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white">
                            Blogs
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<script>
    // Mobile toggle
    // (function() {
    //     const btn = document.getElementById('nav-toggle');
    //     const menu = document.getElementById('primary-menu');
    //     if (!btn || !menu) return;

    //     btn.addEventListener('click', () => {
    //         const open = menu.classList.toggle('hidden') === false;
    //         btn.setAttribute('aria-expanded', String(open));
    //     });

    //     // Close on outside click (mobile and desktop)
    //     document.addEventListener('click', (e) => {
    //         const within = menu.contains(e.target) || btn.contains(e.target);
    //         if (!within && !menu.classList.contains('hidden') && window.innerWidth < 1024) {
    //             menu.classList.add('hidden');
    //             btn.setAttribute('aria-expanded', 'false');
    //         }
    //     });

    //     // ESC to close any open mega menu
    //     document.addEventListener('keydown', (e) => {
    //         if (e.key === 'Escape') {
    //             // close megamenu by blurring focused element
    //             const focused = document.activeElement;
    //             if (focused) focused.blur();
    //         }
    //     });

    //     // Megamenu button ARIA toggle (desktop focus/hover)
    //     const megaBtn = document.querySelector('.has-mega > button');
    //     const megaPanel = document.getElementById('mega-tools');
    //     if (megaBtn && megaPanel) {
    //         function setExpanded(expanded) {
    //             megaBtn.setAttribute('aria-expanded', String(expanded));
    //         }
    //         megaBtn.addEventListener('focus', () => setExpanded(true));
    //         megaBtn.addEventListener('blur', () => setExpanded(false));
    //         megaBtn.addEventListener('mouseenter', () => setExpanded(true));
    //         megaBtn.addEventListener('mouseleave', () => setExpanded(false));
    //         megaPanel.addEventListener('mouseenter', () => setExpanded(true));
    //         megaPanel.addEventListener('mouseleave', () => setExpanded(false));
    //     }
    // })();
</script>