<x-layout2>
    <div class="container py-4">
        <h1 class="h3 text-white text-center fw-bold mb-4">Scanner</h1>

        <div class="d-flex justify-content-center">
            <div class="card bg-white shadow-sm rounded p-4" style="max-width: 550px; width: 100%; position: relative;">
                <a href="{{ route('scanner1') }}"><button class="btn btn-primary btn-lg w-100 mb-3">Scanner Jersey</button></a>
                <a href="{{ route('scanner2') }}"><button class="btn btn-primary btn-lg w-100">Scanner Tiket</button></a>
            </div>
        </div>
    </div>
</x-layout2>
