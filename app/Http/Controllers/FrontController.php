<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Kata;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    // Menampilkan halaman utama (pilih kategori)
    public function index()
    {
        $kategori = Kategori::orderBy('nama', 'asc')->get();
        return view('front.index', compact('kategori'));
    }

    // Menampilkan halaman mode bermain (abjad A-Z)
    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);

        // QUERY SUPER RINGAN: Menghitung total kata dan kata terpakai per huruf
        $statsRaw = Kata::selectRaw('huruf_awal, COUNT(id) as total, SUM(is_used) as terpakai')
                        ->where('kategori_id', $id)
                        ->groupBy('huruf_awal')
                        ->get();

        // Siapkan wadah abjad A-Z bawaan
        $letterStats = [];
        foreach(range('A', 'Z') as $huruf) {
            $letterStats[$huruf] = ['total' => 0, 'terpakai' => 0];
        }

        // Isi wadah dengan hasil dari database
        foreach($statsRaw as $stat) {
            $letterStats[$stat->huruf_awal] = [
                'total' => (int) $stat->total,
                'terpakai' => (int) $stat->terpakai
            ];
        }

        return view('front.play', compact('kategori', 'letterStats'));
    }

    // Mengambil kata berdasarkan huruf yang diklik (Untuk Alpine.js)
    public function getWordsByLetter($id, $huruf)
    {
        $kata = Kata::where('kategori_id', $id)
                    ->where('huruf_awal', $huruf)
                    ->orderBy('is_used', 'asc') // Yang belum dipakai (0) di atas
                    ->orderBy('nama_kata', 'asc') // Urut abjad
                    ->get();

        return response()->json($kata);
    }

    // Mengubah status kata (dicoret/abu-abu)
    public function toggleStatus($id)
    {
        $kata = Kata::findOrFail($id);
        $kata->is_used = !$kata->is_used; // Ubah dari 0 ke 1, atau 1 ke 0
        $kata->save();

        return response()->json(['success' => true, 'is_used' => $kata->is_used]);
    }
}
