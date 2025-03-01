<!DOCTYPE html>
<html>
<head>
    <title>Slides</title>
</head>
<body>
    @foreach($slides as $index => $slide)
        <h1>Slide {{ $index + 1 }}</h1>
        <p>{!! nl2br(e($slide)) !!}</p>
        <hr>
    @endforeach
</body>
</html>