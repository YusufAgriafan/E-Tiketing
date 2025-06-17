<x-layout>
    <div class="container-fluid">
        <h1 class="h3 mb-3 text-gray-800 text-center">Scan QR Code</h1>

        <div class="d-flex justify-content-center">
            <div id="reader" style="width: 500px;"></div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

        <script>
            $(document).ready(function () {
                let isScanning = false;
        
                function onScanSuccess(decodedText, decodedResult) {
                    if (isScanning) return;
        
                    isScanning = true;
                    console.log(`Code matched = ${decodedText}`, decodedResult);
        
                    $.ajax({
                        url: "{{ route('dashboard.scan.liveqr') }}",
                        type: "POST",
                        data: { qr_code: decodedText },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "QR Code Ditemukan",
                                html: `
                                    <b>Nama:</b> ${response.data.nama} <br>
                                    <b>Email:</b> ${response.data.email} <br>
                                    <b>Jumlah Peserta:</b> ${response.data.jumlah_peserta} <br>
                                    <b>Harga:</b> ${response.data.harga} <br>
                                    <b>Tanggal Lunas:</b> ${response.data.tanggal_lunas ? response.data.tanggal_lunas : 'Belum Lunas'}
                                `,
                                icon: "success"
                            });
        
                            setTimeout(() => { isScanning = false; }, 3000);
                        },
                        error: function() {
                            Swal.fire({
                                title: "QR Code Tidak Ditemukan",
                                text: "QR Code Gagal Diverifikasi",
                                icon: "error"
                            });
        
                            setTimeout(() => { isScanning = false; }, 3000);
                        }
                    });
                }
        
                function onScanFailure(error) {
                    console.warn(`Code scan error = ${error}`);
                }
        
                let html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader",
                    { fps: 10, qrbox: { width: 250, height: 250 } },
                    false
                );
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
            });
        </script>
        
    </div>
</x-layout>
