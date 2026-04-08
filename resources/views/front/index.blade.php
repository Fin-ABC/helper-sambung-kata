@extends('layouts.app')

@section('content')
    <!-- Alpine.js mendefinisikan variabel 'search' -->
    <div x-data="{ search: '' }">
        <div class="row mb-4">
            <div class="col-md-8 mx-auto">
                <input type="text" x-model="search" class="form-control form-control-lg"
                    placeholder="🔍 Cari Kategori... (misal: Hewan)">
            </div>
        </div>

        <div class="row g-3">
            @foreach ($kategori as $kat)
                <!-- Alpine.js menyembunyikan div ini jika teks tidak cocok dengan input pencarian -->
                <div class="col-6 col-md-4 col-lg-3" x-show="'{{ strtolower($kat->nama) }}'.includes(search.toLowerCase())">
                    <a href="{{ route('kategori.show', $kat->id) }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0 table-hover">
                            <div class="card-body text-center">
                                <h5 class="card-title text-dark mb-0">{{ $kat->nama }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
