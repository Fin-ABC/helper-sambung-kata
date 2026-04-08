@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 mb-3">
            <h3>Manajemen Data</h3>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
        </div>

        <!-- Form Tambah Kategori -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('admin.kategori.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Nama Kategori Baru</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Tambah Kategori</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Kategori & Import CSV -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Kategori</th>
                                <th>Total Kata</th>
                                <th>Aksi CSV & Reset</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategori as $kat)
                                <tr>
                                    <td>
                                        <strong>{{ $kat->nama }}</strong>
                                        <form action="{{ route('admin.kategori.destroy', $kat->id) }}" method="POST"
                                            class="d-inline mt-1" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-link text-danger p-0 ms-2">Hapus</button>
                                        </form>
                                    </td>
                                    <td>{{ $kat->kata_count }} kata</td>
                                    <td>
                                        <!-- Form Import CSV -->
                                        <form action="{{ route('admin.kata.import') }}" method="POST"
                                            enctype="multipart/form-data" class="d-flex gap-2 mb-2">
                                            @csrf
                                            <input type="hidden" name="kategori_id" value="{{ $kat->id }}">
                                            <input type="file" name="file_csv" class="form-control form-control-sm"
                                                accept=".csv" required>
                                            <button type="submit" class="btn btn-sm btn-success">Import</button>
                                        </form>
                                        <!-- Form Reset Kata -->
                                        <form action="{{ route('admin.kata.reset', $kat->id) }}" method="POST"
                                            onsubmit="return confirm('Reset semua kata di kategori ini menjadi belum dipakai?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning w-100">Reset Status
                                                Kata</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <small class="text-muted">*Pastikan file CSV hanya berisi 1 kolom daftar kata tanpa *header*
                        kolom.</small>
                </div>
            </div>
        </div>
    </div>
@endsection
