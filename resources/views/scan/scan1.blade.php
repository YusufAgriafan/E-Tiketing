<x-layout2>
    <div class="container py-4">
        <h1 class="h3 text-white text-center fw-bold mb-4">Scanner 1</h1>

        <div class="d-flex justify-content-center">
            <div class="card bg-white shadow-sm rounded p-4" style="max-width: 550px; width: 100%; position: relative;">
                <div id="reader" class="mx-auto" style="width: 90%;"></div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            let isScanning = false;

            function onScanSuccess(decodedText, decodedResult) {
                if (isScanning) return;

                isScanning = true;
                console.log(`Code matched = ${decodedText}`, decodedResult);

                $.ajax({
                    url: "{{ route('dashboard.scanner1.qr') }}",
                    type: "POST",
                    data: {
                        qr_code: decodedText
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        const tshirtData = JSON.parse(response.data.tshirt_data);
                        let tshirtDataHtml = '<ul>';
                        tshirtData.forEach(item => {
                            tshirtDataHtml +=
                                `<li>Nama: ${item.nama}, Ukuran: ${item.ukuran}</li>`;
                        });
                        tshirtDataHtml += '</ul>';

                        Swal.fire({
                            html: `
                                <div style="text-align: left; font-family: 'Arial', sans-serif; line-height: 1.6;">
                                    <p>Pembayaran sebesar <b>${response.data.harga.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}</b> untuk <b>${response.data.jumlah_peserta} orang</b> telah terkonfirmasi.</p>
                                    <p>${tshirtDataHtml}</p>
                                    <p>Pengambilan jersey sudah dilakukan. Sampai jumpa di venue acara!</p>
                                    <p style="font-size: 16px; margin-bottom: 2px;">Salam,</p>
                                    <p style="font-size: 16px;">Panitia Event</p>
                                </div>
                            `,
                            icon: "success",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#3085d6"
                        });

                        setTimeout(() => {
                            isScanning = false;
                        }, 3000);
                    },
                    error: function(xhr) {
                        let errorMessage = "Terjadi Kesalahan";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            title: "Error",
                            text: errorMessage,
                            icon: "error"
                        });

                        setTimeout(() => {
                            isScanning = false;
                        }, 3000);
                    }
                });
            }

            function onScanFailure(error) {
                console.warn(`Code scan error = ${error}`);
            }

            let html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                },
                false
            );
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        });
    </script>
</x-layout2>

