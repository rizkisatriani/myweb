<!DOCTYPE html>
<html>
<head>
    <title>Image Enhancer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-5">

    <h2 class="mb-4">Image Upscaler (Waifu2x)</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('enhance.process') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Upload Gambar:</label>
            <input type="file" name="image" class="form-control" required accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Enhance Image</button>
    </form>

    @isset($imagePath)
        <hr>
        <h4>Hasil:</h4>
        <img src="{{ $imagePath }}" alt="Enhanced Image" class="img-fluid mt-3">
    @endisset

</body>
</html>
