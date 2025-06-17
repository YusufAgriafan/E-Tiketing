<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pendaftaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #2c3e50;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }

        .bank-info {
            background: #ecf0f1;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }

        .bank-info p {
            margin: 5px 0;
        }

        .button {
            display: inline-block;
            background: #4f772d;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <p>Yth. <strong>{{ $user->nama }}</strong>,</p>
        <p>Terima kasih telah melakukan registrasi. Untuk
            menyelesaikan proses pendaftaran, silakan melakukan transfer biaya registrasi ke rekening berikut:</p>

        <div class="bank-info">
            <p><strong>Bank:</strong> Bank Rakyat Indonesia</p>
            <p><strong>No. Rekening:</strong> 1234567890</p>
            <p><strong>Atas Nama:</strong> Panitia Event</p>
            <p><strong>Jumlah:</strong> Rp {{ number_format($hargaUnik, 2, ',', '.') }}</p>
        </div>

        <p>Setelah transfer, harap kirimkan bukti pembayaran ke link berikut. Jika ada pertanyaan, jangan ragu untuk
            menghubungi kami melalui chat WA: <strong>+6287733354000 - IVO</strong>
        </p>
        <p>
            <a href="" class="button"
                style="display: inline-block; background: #4f772d; color: #ffffff; text-decoration: none; padding: 10px 15px; border-radius: 5px; margin-top: 10px;">
                Kirim Bukti Pembayaran
            </a>
        </p>

        <p>Sampai jumpa di acara!</p>
        <p>Salam,<br>Panitia Event</p>

        <div class="footer">
            <p>&copy; 2025 E-Tiketing. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
