<?php
declare(strict_types=1);

/**
 * Menghitung subtotal.
 */
function hitungSubtotal(float $harga, int $jumlah): float
{
    return round($harga * $jumlah, 2);
}

/**
 * Menghitung nominal diskon.
 */
function hitungDiskon(
    float $subtotal,
    float $persenDiskon
): float {
    return round($subtotal * $persenDiskon / 100, 2);
}

/**
 * Menghitung pajak dari nilai setelah diskon.
 */
function hitungPajak(
    float $dasarPajak,
    float $persenPajak
): float {
    return round($dasarPajak * $persenPajak / 100, 2);
}

/**
 * Mengubah angka menjadi teks Rupiah.
 */
function formatRupiah(float $nilai): string
{
    return 'Rp ' . number_format($nilai, 2, ',', '.');
}

/**
 * Mengamankan teks untuk ditampilkan pada HTML.
 */
function escape(string $teks): string
{
    return htmlspecialchars(
        $teks,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}

/**
 * Membaca satu nilai teks dari formulir.
 */
function bacaInput(string $namaField): string
{
    $nilai = $_POST[$namaField] ?? '';

    return is_string($nilai) ? trim($nilai) : '';
}