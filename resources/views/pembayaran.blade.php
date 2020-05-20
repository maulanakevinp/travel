<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pembayaran</title>
</head>
<body>
    <div style="width: 100%; text-align: center">
        <div id="qrcode" style="width:400px; height:400px; margin-top:15px;"></div>
    </div>

    <input id="text" type="text" value="" style="width:80%; display: none">

    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/qrcode.js') }}"></script>
</body>
</html>
