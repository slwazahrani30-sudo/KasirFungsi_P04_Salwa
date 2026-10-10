<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/fungsi_kasir.php';

$namaInput = 'Buku Tulis';
$hargaInput = '10000';
$jumlahInput = '3';
$diskonInput = '10';
$pajakInput = '5';

$error = '';
$hasilSiap = false;

$harga = 0.0;
$jumlah = 0;
$persenDiskon = 0.0;
$persenPajak = 0.0;

$subtotal = 0.0;
$diskon = 0.0;
$setelahDiskon = 0.0;
$pajak = 0.0;
$total = 0.0;

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $namaInput = bacaInput('nama');
    $hargaInput = bacaInput('harga');
    $jumlahInput = bacaInput('jumlah');
    $diskonInput = bacaInput('diskon');
    $pajakInput = bacaInput('pajak');

    if ($namaInput === '') {
        $error = 'Nama produk wajib diisi.';
    } elseif (!is_numeric($hargaInput)) {
        $error = 'Harga harus berupa angka.';
    } elseif (
        !is_finite((float) $hargaInput)
        || (float) $hargaInput < 0
        || (float) $hargaInput > 100000000
    ) {
        $error = 'Harga harus antara 0 dan 100.000.000.';
    } elseif (
        filter_var($jumlahInput, FILTER_VALIDATE_INT) === false
    ) {
        $error = 'Jumlah harus berupa bilangan bulat.';
    } elseif (
        (int) $jumlahInput < 0
        || (int) $jumlahInput > 10000
    ) {
        $error = 'Jumlah harus antara 0 dan 10.000.';
    } elseif (!is_numeric($diskonInput)) {
        $error = 'Diskon harus berupa angka.';
    } elseif (
        !is_finite((float) $diskonInput)
        || (float) $diskonInput < 0
        || (float) $diskonInput > 100
    ) {
        $error = 'Diskon harus antara 0 dan 100 persen.';
    } elseif (!is_numeric($pajakInput)) {
        $error = 'Pajak harus berupa angka.';
    } elseif (
        !is_finite((float) $pajakInput)
        || (float) $pajakInput < 0
        || (float) $pajakInput > 100
    ) {
        $error = 'Pajak simulasi harus antara 0 dan 100 persen.';
    } else {
        $harga = (float) $hargaInput;
        $jumlah = (int) $jumlahInput;
        $persenDiskon = (float) $diskonInput;
        $persenPajak = (float) $pajakInput;

        $subtotal = hitungSubtotal($harga, $jumlah);
        $diskon = hitungDiskon($subtotal, $persenDiskon);
        $setelahDiskon = round($subtotal - $diskon, 2);
        $pajak = hitungPajak($setelahDiskon, $persenPajak);
        $total = round($setelahDiskon + $pajak, 2);

        $hasilSiap = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Fungsi — Praktikum 4</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="wadah">
        <header class="kepala">
            <p class="label">PEMROGRAMAN WEB II — PRAKTIKUM 4</p>
            <h1>Kasir Fungsi PHP</h1>
            <p>
                Isi data transaksi dan klik Hitung.
                Hasil dihitung menggunakan fungsi PHP.
            </p>
        </header>

        <div class="kolom">
            <section class="kartu">
                <h2>Data Transaksi</h2>

                <?php if ($error !== ''): ?>
                    <div class="pesan-error" role="alert">
                        <?= escape($error) ?>
                    </div>
                <?php endif; ?>

                <form action="index.php" method="post">
                    <div class="field">
                        <label for="nama">Nama produk</label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            value="<?= escape($namaInput) ?>"
                            maxlength="100"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="harga">Harga satuan</label>
                        <input
                            type="number"
                            id="harga"
                            name="harga"
                            value="<?= escape($hargaInput) ?>"
                            min="0"
                            max="100000000"
                            step="0.01"
                            required
                        >
                        <small>
                            Contoh: 10000. Jangan memakai Rp
                            atau titik pemisah ribuan.
                        </small>
                    </div>

                    <div class="field">
                        <label for="jumlah">Jumlah barang</label>
                        <input
                            type="number"
                            id="jumlah"
                            name="jumlah"
                            value="<?= escape($jumlahInput) ?>"
                            min="0"
                            max="10000"
                            step="1"
                            required
                        >
                    </div>

                    <div class="dua-field">
                        <div class="field">
                            <label for="diskon">Diskon (%)</label>
                            <input
                                type="number"
                                id="diskon"
                                name="diskon"
                                value="<?= escape($diskonInput) ?>"
                                min="0"
                                max="100"
                                step="0.01"
                                required
                            >
                        </div>

                        <div class="field">
                            <label for="pajak">Pajak simulasi (%)</label>
                            <input
                                type="number"
                                id="pajak"
                                name="pajak"
                                value="<?= escape($pajakInput) ?>"
                                min="0"
                                max="100"
                                step="0.01"
                                required
                            >
                        </div>
                    </div>

                    <div class="tombol-grup">
                        <button type="submit">Hitung</button>
                        <a class="tombol-reset" href="index.php">
                            Reset
                        </a>
                    </div>
                </form>
            </section>

            <section class="kartu">
                <h2>Hasil Perhitungan</h2>

                <?php if ($hasilSiap): ?>
                    <p class="nama-produk">
                        <?= escape($namaInput) ?>
                    </p>

                    <table>
                        <tbody>
                            <tr>
                                <th scope="row">Harga satuan</th>
                                <td><?= formatRupiah($harga) ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Jumlah</th>
                                <td><?= $jumlah ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Subtotal</th>
                                <td><?= formatRupiah($subtotal) ?></td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    Diskon <?= $persenDiskon ?>%
                                </th>
                                <td><?= formatRupiah($diskon) ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Setelah diskon</th>
                                <td>
                                    <?= formatRupiah($setelahDiskon) ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    Pajak <?= $persenPajak ?>%
                                </th>
                                <td><?= formatRupiah($pajak) ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="total">
                        <span>Total bayar</span>
                        <strong><?= formatRupiah($total) ?></strong>
                    </div>
                <?php else: ?>
                    <div class="kosong">
                        <p>Hasil belum tersedia.</p>
                        <p>Isi formulir, kemudian klik Hitung.</p>
                    </div>
                <?php endif; ?>

                <p class="catatan">
                    Pajak dihitung dari nilai setelah diskon.
                    Persentase pajak merupakan simulasi praktikum.
                </p>
            </section>
        </div>

        <footer>
            <a href="uji.php">Buka pengujian fungsi</a>
        </footer>
    </main>
</body>
</html>