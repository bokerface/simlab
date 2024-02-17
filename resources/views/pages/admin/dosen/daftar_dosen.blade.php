<x-layouts>
    <div class="col-12">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                {{-- {{ print_r($data) }} --}}
                <x-table :kolom="$kolom" :isi="$isi"></x-table>
            </div>
        </div>
    </div>

    <x-slot name='js'></x-slot>
</x-layouts>