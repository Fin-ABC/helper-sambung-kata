<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Kata;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Menampilkan kategori beserta jumlah kata di dalamnya
        $kategori = Kategori::withCount('kata')->orderBy('nama', 'asc')->get();
        return view('admin.index', compact('kategori'));
    }

    public function storeKategori(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        Kategori::create(['nama' => $request->nama]);

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroyKategori($id)
    {
        Kategori::findOrFail($id)->delete();
        return back()->with('success', 'Kategori dihapus!');
    }

    // FITUR IMPORT CSV SUPER RINGAN
    public function importKata(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'file_csv' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file_csv');
        $handle = fopen($file->getRealPath(), "r");

        $dataInsert = [];
        $now = now();

        // Membaca baris per baris tanpa membebani RAM
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $namaKata = trim($row[0]); // Ambil kolom pertama

            if (!empty($namaKata)) {
                $dataInsert[] = [
                    'kategori_id' => $request->kategori_id,
                    'nama_kata' => $namaKata,
                    'huruf_awal' => strtoupper(substr($namaKata, 0, 1)), // Potong huruf pertama otomatis
                    'is_used' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        fclose($handle);

        // Insert ke SQLite sekaligus dalam hitungan detik
        if (!empty($dataInsert)) {
            Kata::insert($dataInsert);
        }

        return back()->with('success', count($dataInsert) . ' kata berhasil diimport!');
    }

    // Reset kata menjadi belum dipakai semua
    public function resetKata($id)
    {
        Kata::where('kategori_id', $id)->update(['is_used' => 0]);
        return back()->with('success', 'Semua kata di kategori ini berhasil di-reset!');
    }
}
