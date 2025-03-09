<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print QR Code</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .print-btn {
            margin: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background: blue;
            color: white;
            border: none;
            cursor: pointer;
        }
        .print-btn:hover {
            background: darkblue;
        }
    </style>
</head>
<body>
    <h1>QR Code</h1>
    {!! $qrCode !!} <!-- Display the QR Code -->
    
    <br>

    <button id="print" class="print-btn" onclick="window.print();">Print QR Code</button> 
</body>
</html>
