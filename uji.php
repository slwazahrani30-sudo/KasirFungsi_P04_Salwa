<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/fungsi_kasir.php';

function tampilkanUji(
    string $nama,
    float $aktual,
    float $harapan
): void {
    $lulus = abs($aktual - $harapan) < 0.001;
    $status = $lulus ? 'LULUS' : 'GAGAL';
    $kelas = $lulus ? 'lulus' : 'gagal';

    echo '<tr>';
    echo '<th scope="row">' . escape($nama) . '</th>';
    echo '<td>' . formatRupiah($aktual) . '</td>';
    echo '<td>' . formatRupiah($harapan) . '</td>';
    echo '<td class="' . $kelas . '">' . $status . '</td>';
    echo '</tr>';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengujian Fungsi Kasir</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="wadah">
        <header class="kepala">
            <p class="label">PRAKTIKUM WEB II — PERTEMUAN 4</p>
            <h1>Pengujian Fungsi Kasir</h1>
            <p>
                Hasil aktual dibandingkan dengan nilai harapan.
                Semua baris harus menampilkan LULUS.
            </p>
        </header>

        <section class="kartu tabel-uji">
            <table>
                <thead>
                    <tr>
                        <th scope="col">Pengujian</th>
                        <th scope="col">Hasil aktual</th>
                        <th scope="col">Harapan</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    tampilkanUji(
                        'Subtotal 3 buku',
                        hitungSubtotal(10000.0, 3),
                        30000.0
                    );

                    tampilkanUji(
                        'Subtotal jumlah nol',
                        hitungSubtotal(10000.0, 0),
                        0.0
                    );

                    tampilkanUji(
                        'Subtotal harga pecahan',
                        hitungSubtotal(1250.50, 2),
                        2501.0
                    );

                    tampilkanUji(
                        'Diskon 10 persen',
                        hitungDiskon(30000.0, 10.0),
                        3000.0
                    );

                    tampilkanUji(
                        'Diskon nol persen',
                        hitungDiskon(30000.0, 0.0),
                        0.0
                    );

                    tampilkanUji(
                        'Diskon 100 persen',
                        hitungDiskon(30000.0, 100.0),
                        30000.0
                    );

                    tampilkanUji(
                        'Pajak setelah diskon',
                        hitungPajak(27000.0, 5.0),
                        1350.0
                    );

                    tampilkanUji(
                        'Pajak nol persen',
                        hitungPajak(27000.0, 0.0),
                        0.0
                    );

                    $subtotal = hitungSubtotal(10000.0, 3);
                    $diskon = hitungDiskon($subtotal, 10.0);
                    $setelahDiskon = round($subtotal - $diskon, 2);
                    $pajak = hitungPajak($setelahDiskon, 5.0);
                    $total = round($setelahDiskon + $pajak, 2);

                    tampilkanUji(
                        'Total transaksi',
                        $total,
                        28350.0
                    );
                    ?>
                </tbody>
            </table>
        </section>

        <footer>
            <a href="index.php">Kembali ke halaman kasir</a>
        </footer>
    </main>
</body>
</html>