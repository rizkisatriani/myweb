<!DOCTYPE html>
 <html lang="en">
<head>
    <link rel="canonical" href="{{ url()->current() }}" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toolsborg | {{ $title }}</title>

    <!-- Meta SEO -->
    <meta name="title" content="{{ $title }}">
    <meta name="description" content="{{ $subtitle }}">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Themesberg">

    <!-- Social media share -->
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:site_name" content=Themesberg>
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ $subtitle }}">
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
    <link href="./output.css" rel="stylesheet">
    <script async defer src="https://buttons.github.io/buttons.js"></script>
        <script>
        function handleFileSelect(event) {
            const uploadButton = document.getElementById('convert-button');
            if (event.target.files.length > 0) {
                uploadButton.classList.remove('hidden');
            } else {
                uploadButton.classList.add('hidden');
            }
        }

        function handleConvert() {
            alert("Converting image to PDF...");
            // You can add functionality here for the actual conversion
        }
    </script>
</head>
<body>
    <?php include 'components/topnav.php'; ?> 
       <section class="bg-white dark:bg-gray-900">
    <div class="max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="container mx-auto">
            <!-- Breadcrumb -->
            <div class="text-sm text-gray-600 mb-4">
                <a href="#" class="text-gray-500 hover:text-purple-600">Home</a> &gt; 
                <a href="#" class="text-gray-500 hover:text-purple-600">Photo Editor</a> &gt; 
                <span class="text-purple-800 font-semibold">{{$breadCrumb}}</span>
            </div>

            <!-- Main Section -->
            <div class="relative bg-purple-100 rounded-lg p-8">
                <!-- Background Decorations -->
                <div class="absolute top-0 left-0 w-16 h-16 bg-purple-200 rounded-full transform -translate-x-4 -translate-y-4"></div>
                <div class="absolute bottom-0 right-0 w-20 h-20 bg-purple-300 rounded-full transform translate-x-4 translate-y-4"></div>
                
                <!-- Content -->
                <div class="relative z-10 bg-white rounded-xl p-10">
                    <h1 class="text-3xl font-extrabold text-gray-800 text-center mb-4">{{ $title }}</h1>
                    <p class="text-gray-600 text-center mb-6">
                       {{ $subtitle }}
                    </p>
                
                    <!-- Upload Button -->
                    <div class="text-center">
                        <label for="file-upload" 
                            class="cursor-pointer inline-flex items-center px-5 py-3 bg-purple-600 text-white text-lg font-semibold rounded-lg shadow-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                            <path d="M12 2v12M12 2L8 6M12 2l4 4M4 16h16"></path>
                        </svg>
                            Upload your image
                        </label>
                        <input id="file-upload" type="file" accept="image/*" class="hidden" onchange="handleFileSelect(event)" />
                    </div>

                    <!-- Dropzone Text -->
                    <p class="text-gray-500 text-center mt-4">or drop it here</p>

                    <!-- Convert Button (hidden initially) -->
                    <form action="{{ url($actionUrl) }}" method="POST" enctype="multipart/form-data" class="space-y-6 flex justify-center pt-20">
                        @csrf
                        <input type="file" name="image" id="selected-file" class="hidden" required />
                        <button id="convert-button" 
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center"
                            type="submit" style="display:none;">
                            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                            Convert File Now
                        </button>
                    </form>
                        @if ($errors->any())
                    <div class="bg-red-100 text-red-700 border border-red-400 rounded p-4 mb-4">
                        <strong class="block font-medium">Error!</strong>
                        <ul class="list-disc list-inside mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div> 
        </div>
    </div>
</section>
<section id="image-conversion" class="max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
    <h1 class="text-3xl font-semibold text-center mb-4">Fast and Easy Image File Conversion Service</h1>
    <p class="text-lg text-gray-700 mb-6">
        Need to convert your image files to a different format? Whether it's for optimizing file size, improving quality, or simply changing the file type for easier sharing, our image file conversion service is here to help. At <strong>Service Name</strong>, you can easily convert your images between various formats quickly, with no extra software or complicated steps required.
    </p>

    <h2 class="text-2xl font-medium text-purple-700 mb-4">Why Convert Image Files?</h2>
    <p class="text-lg text-gray-700 mb-6">
        Image file conversion allows you to switch between formats for different purposes. Whether you want to make the file size smaller for faster loading or improve the image quality for printing, our service offers a simple solution. You can also combine images into one document or convert them into a format that's better suited for web or app use. 
    </p>

    <h2 class="text-2xl font-medium text-purple-700 mb-4">Benefits of Using Our Image Conversion Service</h2>
    <ul class="list-disc list-inside text-lg text-gray-700 mb-6">
        <li>Quick and efficient conversion process, no software installation required.</li>
        <li>Supports a variety of image formats, making it flexible for all your needs.</li>
        <li>High-quality output with preserved image integrity after conversion.</li>
        <li>Free and easy to use—convert your images in just a few clicks.</li>
    </ul>

    <h2 class="text-2xl font-medium text-purple-700 mb-4">How It Works</h2>
    <p class="text-lg text-gray-700 mb-6">
        Our service is simple and user-friendly. Just upload your image, choose the desired output format, and let us handle the rest. The conversion process is fast, and you’ll receive the converted image in seconds. Whether you're converting for professional or personal use, we make it easier than ever to get the right format for your needs.
    </p>

    <h2 class="text-2xl font-medium text-purple-700 mb-4">Get Started with Image Conversion</h2>
    <p class="text-lg text-gray-700 mb-6">
        Don’t let file format issues slow you down. Start converting your images today with our fast and easy image conversion tool. Click the button below to begin!
    </p> 
</section>
<script>
    // Function to handle file selection
    function handleFileSelect(event) {
        const fileInput = event.target;
        const convertButton = document.getElementById('convert-button');
        const selectedFileInput = document.getElementById('selected-file');
        
        if (fileInput.files.length > 0) {
            // Show the Convert button
            convertButton.style.display = 'inline-flex';
            selectedFileInput.files = fileInput.files; // Attach the selected file to the hidden form input
        } else {
            convertButton.style.display = 'none';
        }
    }

    // Optional: If you need to handle form submission dynamically with AJAX, you can use the following code.
    // document.getElementById('convert-form').addEventListener('submit', function(event) {
    //     event.preventDefault();
    //     // Handle AJAX submission here if needed
    //     // Example: send the form data via fetch or XMLHttpRequest
    // });
</script>
      
    <?php include 'components/footer.php'; ?>
        
</body>
</html>