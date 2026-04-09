@extends('layouts.app')

@section('content')
    <!-- Inisialisasi state Alpine.js -->
    <div x-data="wordGame('{{ $kategori->id }}')">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Kategori: {{ $kategori->nama }}</h4>

            <!-- Tombol Toggle Layout (List/Grid) -->
            <button @click="isGrid = !isGrid" class="btn btn-outline-dark btn-sm">
                <span x-text="isGrid ? 'Beralih ke Mode List' : 'Beralih ke Mode Grid'"></span>
            </button>
        </div>

        <div class="row">
            <!-- Sidebar Tombol Abjad A-Z -->
            <div class="col-md-2 col-3">
                <div class="d-grid gap-1">
                    @foreach (range('A', 'Z') as $huruf)
                        <button @click="fetchWords('{{ $huruf }}')"
                            :class="activeLetter === '{{ $huruf }}' ? 'btn-primary' : 'btn-outline-primary'"
                            class="btn btn-sm fw-bold">
                            {{ $huruf }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Area Tampilan Kata -->
            <div class="col-md-10 col-9">
                <div x-show="words.length === 0" class="alert alert-info">
                    Pilih huruf di samping untuk menampilkan kata.
                </div>

                <!-- Wrapper dinamis berdasarkan state isGrid -->
                <div :class="isGrid ? 'row g-2' : 'list-group'">
                    <template x-for="word in words" :key="word.id">
                        <!-- Elemen Kata -->
                        <div @click="toggleWord(word)" class="cursor-pointer"
                            :class="[
                                isGrid ? 'col-6 col-md-4 col-lg-3' : 'list-group-item list-group-item-action',
                                word.is_used ? 'text-decoration-line-through text-secondary bg-light' : 'fw-bold'
                            ]">
                            <!-- Bungkus dengan card jika mode Grid -->
                            <div :class="isGrid ? 'card shadow-sm border-0' : ''">
                                <div :class="isGrid ? 'card-body text-center' : ''">
                                    <span x-text="word.nama_kata"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Logika Alpine.js -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('wordGame', (kategoriId) => ({
                words: [],
                activeLetter: '',
                isGrid: false, // Default: mode List vertikal

                async fetchWords(letter) {
                    this.activeLetter = letter;
                    // Ambil data JSON dari backend
                    const response = await fetch(`/api/kategori/${kategoriId}/huruf/${letter}`);
                    this.words = await response.json();
                },

                async toggleWord(word) {
                    // 1. Ubah UI secara instan (optimistic update)
                    word.is_used = word.is_used ? 0 : 1;
                    this.sortWords(); // Urutkan ulang agar yang dicoret pindah ke bawah

                    // 2. Kirim update ke database di latar belakang
                    await fetch(`/api/kata/${word.id}/toggle`);
                },

                sortWords() {
                    // Logika pengurutan: yang is_used=0 di atas, is_used=1 di bawah.
                    // Jika sama statusnya, urutkan sesuai abjad.
                    this.words.sort((a, b) => {
                        if (a.is_used === b.is_used) {
                            return a.nama_kata.localeCompare(b.nama_kata);
                        }
                        return a.is_used ? 1 : -1;
                    });
                }
            }))
        })
    </script>
@endsection
