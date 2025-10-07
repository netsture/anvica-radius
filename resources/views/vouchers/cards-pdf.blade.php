<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        .card {
            width: 45%;
            display: inline-block;
            border: 1px solid #ccc;
            margin: 10px;
            border-radius: 10px;
            overflow: hidden;
        }
        .header {
            background: red;
            color: white;
            text-align: center;
            padding: 5px;
            font-weight: bold;
        }
        .content {
            padding: 10px;
        }
        .footer {
            background: #eee;
            text-align: center;
            padding: 5px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h2>Voucher Series: {{ $series }}</h2>
    @foreach($vouchers as $voucher)
    <div class="card">
        <div class="header">Prepaid Card</div>
        <div class="content">
            <p><strong>500 MB download traffic</strong></p>
            <p>User name: <strong>{{ $voucher->cardnum }}</strong></p>
            <p>Password: <strong>{{ $voucher->password }}</strong></p>
            <p>Valid till: {{ $voucher->expiration }}</p>
            <small>Series: {{ $voucher->series }}</small>
        </div>
        <div class="footer">Powered by Anvica Hotspot</div>
    </div>
    @endforeach
</body>
</html>
