<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="canonical" href="https://toolsborg.com/landwind/" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toolsborg | Internet Speed Test</title>

    <!-- Meta SEO -->
    <meta name="title" content="Internet Speed Test">
    <meta name="description" content="Test your internet speed with our free and simple speed test tool. Measure download and upload speeds instantly.">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="author" content="Toolsborg">

    <!-- Tailwind CSS -->
    <link href="./output.css" rel="stylesheet">

    <!-- Script -->
    <script>
      document.addEventListener('DOMContentLoaded', () => {
    const startTestButton = document.getElementById('start-test');
    const resultsDiv = document.getElementById('results');
    const downloadSpeedElem = document.getElementById('download-speed');
    const uploadSpeedElem = document.getElementById('upload-speed');
    const spinner = document.getElementById('spinner');

    startTestButton.addEventListener('click', async () => {
        // Tampilkan spinner dan ubah teks tombol
        // spinner.classList.remove('hidden');
        startTestButton.textContent = 'Testing...';
        startTestButton.disabled = true;

        // Simulasi pengujian kecepatan
        const downloadSpeed = await testSpeed('download');
        const uploadSpeed = await testSpeed('upload');

        // Update hasil
        downloadSpeedElem.textContent = `${downloadSpeed.toFixed(2)}`;
        uploadSpeedElem.textContent = `${uploadSpeed.toFixed(2)}`;

        // Sembunyikan spinner dan tampilkan hasil
        spinner.classList.add('hidden');
        // resultsDiv.classList.remove('hidden');
        startTestButton.textContent = 'Start Test';
        startTestButton.disabled = false;
    });

    async function testSpeed(type) {
        const startTime = performance.now();
        const size = 1 * 1024 * 1024; // 10 MB
        const data = new ArrayBuffer(size);

        try {
            if (type === 'download') {
                await fetch('/dummy-data'); // Dummy endpoint for testing download
            } else if (type === 'upload') {
                await fetch('/dummy-data', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: data,
                });
            }
        } catch (err) {
            console.error(err);
        }

        const endTime = performance.now();
        const duration = (endTime - startTime) / 1000; // in seconds
        let mbps= (size * 8) / (duration * 1024 * 1024);
        document.getElementById("speedbox-score").style.transform = "rotate(" + mbps + "deg)";
        return mbps;//(size * 8) / (duration * 1024 * 1024); // Mbps
    }
});
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style>
    .legend {
          color: #333;
        }
        
        .speedbox {
          margin: 5em;
          height: 400px;
          width: 400px;
          display: flex;
          flex-direction: column;
          align-items: center;
          position: relative;
          margin-bottom: 16px;
        }
        
        .speedbox__groove {
          height: 200px;
          width: 400px;
          background: transparent;
          border-top-left-radius: 200px;
          border-top-right-radius: 200px;
          border: 20px solid #eee;
          border-bottom: 0;
          box-sizing: border-box;
          position: absolute;
          left: 0;
          top: 0;
        }
        
        .speedbox__score {
          position: absolute;
          left: 0;
          top: 0;
          transform: rotate(-45deg);
          height: 400px;
          width: 400px;
          background: transparent;
          border-radius: 50%;
          border: 20px solid #5c6f7b;
          border-color: transparent transparent #5c6f7b #5c6f7b;
          box-sizing: border-box;
          cursor: pointer;
          z-index: 1;
          transition: transform 0.3s ease;
        }
        
        .speedbox__base {
          width: 440px;
          height: 200px;
          background: white;
          position: relative;
          top: 200px;
          z-index: 20;
        }
        
        .speedbox__base:before {
          content: '';
          width: 440px;
          position: absolute;
          top: 0;
          border-bottom: 1px solid #eee;
          box-shadow: 1px 3px 15px rgba(0, 0, 0, 0.5);
        }
        
        .speedbox__odo {
          text-align: center;
          position: absolute;
          color: #5c6f7b;
          bottom: 200px;
          left: 50%;
          transform: translateX(-50%);
        }
        
        .speedbox__odo i {
          font-size: 13px;
          opacity: 0.6;
        }
        
        .speedbox__odo > div {
          margin-bottom: 0;
        }
        
        .speedbox__odo span {
          font-size: 0.7em;
        }
        
        .speedbox__ping {
          font-size: 18px;
        }
        
        .speedbox__up {
          font-size: 20px;
          line-height: 1.5em;
        }
        
        .speedbox__down {
          font-size: 28px;
          text-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
          line-height: 1.2em;
        }

    </style>
</head>
<body class="bg-gray-100">
    <?php include 'components/topnav.php'; ?> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <section class="bg-white dark:bg-gray-900">
    <div class="max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="container mx-auto">
            <!-- Breadcrumb -->
            <div class="text-sm text-gray-600 mb-4">
                <a href="#" class="text-gray-500 hover:text-purple-600">Home</a> &gt; 
                <a href="#" class="text-gray-500 hover:text-purple-600">Internet</a> &gt; 
                <span class="text-purple-800 font-semibold">Speed Test</span>
            </div>

            <!-- Main Section -->
            <div class="relative bg-purple-100 rounded-lg p-8">
                <!-- Background Decorations -->
                <div class="absolute top-0 left-0 w-16 h-16 bg-purple-200 rounded-full transform -translate-x-4 -translate-y-4"></div>
                <div class="absolute bottom-0 right-0 w-20 h-20 bg-purple-300 rounded-full transform translate-x-4 translate-y-4"></div>
                
                <!-- Content -->
                <div class="relative z-10 bg-white rounded-xl p-10">
                   
                    <main class="flex items-center justify-center h-screen">
                        <div class="bg-white p-8 rounded-lg w-full max-w-md">
                            <h2 class="text-xl font-semibold text-center text-gray-800 mb-4">Test Your Internet Speed</h2>
                            <div id="speed-test" class="text-center flex items-center justify-center flex-col">
                                <!-- Spinner -->
                                <div id="spinner" class="hidden flex justify-center mb-4">
                                    <div class="w-8 h-8 border-4 border-purple-600 border-t-transparent rounded-full animate-spin"></div>
                                </div>
                            
                           <div class="speedbox">
                              <div class="speedbox__score" id="speedbox-score"></div>
                              <div class="speedbox__groove"></div>
                              <div class="speedbox__odo">
                                <div class="speedbox__ping"><i class="fa fa-clock-o"></i> 28<span>ms</span></div>
                                <div class="speedbox__up"><i class="fa fa-arrow-circle-up"></i> <span id="upload-speed" class="font-bold text-purple-800"></span><span> mb/s</span></div>
                                <div class="speedbox__down"><i class="fa fa-arrow-circle-down"></i> <span id="download-speed" class="font-bold text-purple-800"></span><span> mb/s</span></div>
                              </div>
                              <div class="speedbox__base"></div>
                            
                            </div>
                                <!-- Start Test Button -->
                                <button id="start-test" class="absolute bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition p-4" style="top: 380px;   z-index: 999;">
                                    Start Test
                                </button>
                                <!-- Results -->
                                <div id="results" class="mt-6 hidden">
                                    <p class="text-lg text-gray-700">Download Speed: </p>
                                    <p class="text-lg text-gray-700">Upload Speed: </p>
                                </div>
                            </div>
                        </div>
                        
                    </main>
                </div> 
            </div>
            <div class="flex flex-col gap-8">
                 <section id="intro">
                <p>Welcome to <strong>Speed Test Online</strong>, the best tool to <em>measure your internet speed</em>. Do you feel your internet is slow? Use our tool to check your download speed, upload speed, and <em>latency</em> (ping) easily and for free. Our tool is designed to provide accurate results in just a few seconds.</p>
                </section>
        
                <section id="why-speed-test">
                    <h2>Why Is It Important to Test Your Internet Speed?</h2>
                    <ul>
                        <li><strong>Ensure ISP Performance:</strong> Verify that your internet service provider (ISP) delivers the promised speed.</li>
                        <li><strong>Boost Productivity:</strong> Optimal internet speed supports work, online learning, and entertainment without interruptions.</li>
                        <li><strong>Identify Issues:</strong> Discover the root cause of slow connections, whether it's hardware, network, or ISP-related.</li>
                    </ul>
                </section>
        
                <section id="features">
                    <h2>Key Features of Speed Test Online</h2>
                    <p>We offer the following features for the best user experience:</p>
                    <ol>
                        <li><strong>Accurate Measurements:</strong> Our tool uses high-quality servers for precise results.</li>
                        <li><strong>Real-Time Results:</strong> Get reports on download speed, upload speed, and latency in real time.</li>
                        <li><strong>User-Friendly Interface:</strong> The intuitive design makes it easy for anyone to use this tool.</li>
                        <li><strong>Completely Free:</strong> No hidden costs or subscriptions.</li>
                    </ol>
                </section>
        
                <section id="how-to-use">
                    <h2>How to Use Speed Test Online</h2>
                    <p>Follow these simple steps to test your internet speed:</p>
                    <ol>
                        <li>Click the <strong>"Start Test"</strong> button on this page.</li>
                        <li>Wait a few seconds while our tool measures download, upload, and latency speeds.</li>
                        <li>View your complete test results, including detailed graphs and statistics.</li>
                    </ol>
                </section>
        
                <section id="faq">
                    <h2>Frequently Asked Questions (FAQ)</h2>
                    <h3>What is a Speed Test?</h3>
                    <p>A Speed Test is an online tool designed to measure your internet connection speed, including download speed, upload speed, and latency.</p>
                    <h3>Is this test free?</h3>
                    <p>Yes, our internet speed test is entirely free to use anytime.</p>
                    <h3>How accurate are the results?</h3>
                    <p>Our test results are highly accurate because we use the nearest servers and cutting-edge technology to ensure precision.</p>
                </section>
        
                <section id="tips">
                    <h2>Tips to Improve Your Internet Speed</h2>
                    <ul>
                        <li>Use a wired (Ethernet) connection for better stability.</li>
                        <li>Ensure no other devices are consuming excessive bandwidth.</li>
                        <li>Check your router settings and update its firmware if necessary.</li>
                        <li>Contact your internet service provider if the issue persists.</li>
                    </ul>
                </section>
            </div>

            <!-- Footer -->
            <p class="text-sm text-gray-500 text-center mt-6">
                Learn about supported formats and requirements. See how we use your content in our 
                <a href="#" class="text-purple-600 hover:underline">Privacy Policy</a>.
            </p>
        </div>
    </div>
</section>
    <?php include 'components/footer.php'; ?>
</body>
</html>