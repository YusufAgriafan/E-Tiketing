<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Registrasi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
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
            color: #4CAF50;
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin: 0px;
            color: #333;
        }

        img {
            max-width: 200px;
        }

        .footer {
            font-size: 14px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <p>Yth. <strong>{{ $user->nama }}</strong>,</p>
        <p>Terima kasih atas pembayaran Anda untuk acara Event. Pembayaran Anda telah
            kami terima.</p><br />

        <img src="{{ asset('storage/' . $qrCodePath) }}" alt="QR Code"><br />

        <p>Terlampir QR Code untuk bukti pembayaran Anda. Harap simpan dan tunjukkan QR Code kepada panitia saat: </p>
        <p>✅ Pengambilan jersey acara</p>
        <p>✅ Masuk ke Venue</p><br />

        <p>Jika ada pertanyaan, silakan hubungi kami.</p>
        <p>Sampai jumpa di acara!</p><br />
        {{-- <p>
            <a href="https://example.com/upload-bukti"
                class="button"
                style="display: inline-block; background: #4f772d; color: #ffffff; text-decoration: none; padding: 10px 15px; border-radius: 5px; margin-top: 10px;">
                Kirim Bukti Pembayaran
            </a>
        </p> --}}
        <p>Salam,<br>Panitia Event</p><br />

        <div class="footer">
            <p>&copy; 2025 E-Tiketing. All rights reserved.</p>
        </div>
    </div>
</body>

</html>

