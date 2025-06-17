@if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    title: "Registrasi Berhasil!",
                    html: `{!! session('success') !!}`,
                    icon: "success"
                });
            @endif
        });
    </script>
@elseif (session('error'))
    <script>
        Swal.fire({
            title: 'Gagal!',
            html: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
@elseif ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            Swal.fire({
                title: 'Gagal!',
                html: '{{ $error }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endforeach
@elseif (session('warning'))
    <script>
        Swal.fire({
            title: 'Peringatan!',
            html: '{{ session('warning') }}',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
    </script>
@elseif (session('info'))
    <script>
        Swal.fire({
            title: 'Informasi',
            html: '{{ session('info') }}',
            icon: 'info',
            confirmButtonText: 'OK'
        });
    </script>
@endif
