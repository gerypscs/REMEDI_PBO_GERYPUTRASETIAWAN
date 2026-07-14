<?php
// 1. Include semua class yang dibutuhkan
require_once 'Reservasi.php';
require_once 'ReservasiReguler.php';
require_once 'ReservasiPremium.php';
require_once 'ReservasiEvent.php';

// 2. Koneksi ke Database (Sesuaikan dengan konfigurasi XAMPP/MySQL Anda)
$host     = "localhost";
$username = "root";
$password = "";
$database = "nama_database_anda"; // Ganti dengan nama database Anda

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// 3. Ambil data dari database
$query = "SELECT * FROM tabel_reservasi";
$result = $conn->query($query);

// 4. Siapkan array penampung untuk masing-masing kelompok objek
$daftarReguler = [];
$daftarPremium = [];
$daftarEvent   = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Polimorfisme & Instansiasi Objek berdasarkan jenis_paket
        if ($row['jenis_paket'] == 'Reguler') {
            $daftarReguler[] = new ReservasiReguler(
                $row['id_reservasi'], $row['nama_pelanggan'], $row['tanggal_booking'],
                $row['durasi_jam'], $row['tarif_dasar_per_jam'],
                $row['tipe_background'], $row['cetak_foto_lembar']
            );
        } elseif ($row['jenis_paket'] == 'Premium') {
            // Konversi nilai 1/0 dari database ke boolean untuk layanan_makeup
            $isMakeup = $row['layanan_makeup'] ? true : false;
            $daftarPremium[] = new ReservasiPremium(
                $row['id_reservasi'], $row['nama_pelanggan'], $row['tanggal_booking'],
                $row['durasi_jam'], $row['tarif_dasar_per_jam'],
                $row['kuota_talent_orang'], $isMakeup
            );
        } elseif ($row['jenis_paket'] == 'Event') {
            $daftarEvent[] = new ReservasiEvent(
                $row['id_reservasi'], $row['nama_pelanggan'], $row['tanggal_booking'],
                $row['durasi_jam'], $row['tarif_dasar_per_jam'],
                $row['nama_lokasi_luar'], $row['biaya_transportasi_tim']
            );
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Transaksi Reservasi Studio Foto</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f9f9f9; color: #333; }
        h1 { text-align: center; color: #2c3e50; }
        h2 { margin-top: 40px; color: #2980b9; border-bottom: 2px solid #2980b9; padding-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 12px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #34495e; color: #fff; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .badge-reguler { background-color: #e1f5fe; color: #0288d1; }
        .badge-premium { background-color: #ede7f6; color: #5e35b1; }
        .badge-event { background-color: #efebe9; color: #5d4037; }
    </style>
</head>
<body>

    <h1>Daftar Transaksi Reservasi Studio Foto</h1>

    <!-- ================= TABEL KATEGORI REGULER ================= -->
    <h2><span class="badge badge-reguler">Kategori</span> Paket Reguler</h2>
    <table>
        <thead>
            <tr>
                <th>ID Reservasi</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal Booking</th>
                <th>Durasi (Jam)</th>
                <th>Tarif / Jam</th>
                <th>Tipe Background</th>
                <th>Cetak Foto</th>
                <th>Total Biaya (+ Biaya Kebersihan/Kamera)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($daftarReguler)): ?>
                <tr><td colspan="8" style="text-align:center;">Tidak ada data paket reguler.</td></tr>
            <?php else: ?>
                <?php foreach ($daftarReguler as $reguler): ?>
                    <?php 
                    // Menggunakan Reflection/Getter jika properti protected, 
                    // namun demi kemudahan visualisasi antarmuka, kita panggil laporannya via method atau langsung baca properti (jika scope mengizinkan).
                    // Catatan: Karena properti $idReservasi dkk bersifat protected, di scope file luar kita bisa mengakalinya dengan merubah class induk ditambahkan getter, 
                    // atau dalam simulasi ini kita panggil metodenya secara OOP.
                    
                    // Untuk kebutuhan antarmuka bersih, berikut refleksi nilainya melalui object:
                    $ref = new ReflectionClass($reguler);
                    $props = [];
                    foreach ($ref->getParentClass()->getProperties() as $p) {
                        $p->setAccessible(true);
                        $props[$p->getName()] = $p->getValue($reguler);
                    }
                    foreach ($ref->getProperties() as $p) {
                        $p->setAccessible(true);
                        $props[$p->getName()] = $p->getValue($reguler);
                    }
                    ?>
                    <tr>
                        <td><?= $props['idReservasi']; ?></td>
                        <td><?= $props['namaPelanggan']; ?></td>
                        <td><?= date('d-m-Y', strtotime($props['tanggalBooking'])); ?></td>
                        <td><?= $props['durasiJam']; ?> Jam</td>
                        <td class="text-right">Rp <?= number_format($props['tarifDasarPerJam'], 0, ',', '.'); ?></td>
                        <td><?= $props['tipeBackground']; ?></td>
                        <td><?= $props['cetakFotoLembar']; ?> Lembar</td>
                        <td class="text-right" style="font-weight:bold;">Rp <?= number_format($reguler->hitungTotalBiaya(), 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- ================= TABEL KATEGORI PREMIUM ================= -->
    <h2><span class="badge badge-premium">Kategori</span> Paket Premium</h2>
    <table>
        <thead>
            <tr>
                <th>ID Reservasi</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal Booking</th>
                <th>Durasi (Jam)</th>
                <th>Tarif / Jam</th>
                <th>Kuota Talent</th>
                <th>Layanan Makeup</th>
                <th>Total Biaya (+ Surcharge 20%)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($daftarPremium)): ?>
                <tr><td colspan="8" style="text-align:center;">Tidak ada data paket premium.</td></tr>
            <?php else: ?>
                <?php foreach ($daftarPremium as $premium): ?>
                    <?php 
                    $ref = new ReflectionClass($premium);
                    $props = [];
                    foreach ($ref->getParentClass()->getProperties() as $p) {
                        $p->setAccessible(true);
                        $props[$p->getName()] = $p->getValue($premium);
                    }
                    foreach ($ref->getProperties() as $p) {
                        $p->setAccessible(true);
                        $props[$p->getName()] = $p->getValue($premium);
                    }
                    ?>
                    <tr>
                        <td><?= $props['idReservasi']; ?></td>
                        <td><?= $props['namaPelanggan']; ?></td>
                        <td><?= date('d-m-Y', strtotime($props['tanggalBooking'])); ?></td>
                        <td><?= $props['durasiJam']; ?> Jam</td>
                        <td class="text-right">Rp <?= number_format($props['tarifDasarPerJam'], 0, ',', '.'); ?></td>
                        <td><?= $props['kuotaTalentOrang']; ?> Orang</td>
                        <td><?= $props['layananMakeup'] ? '✓ Tersedia' : '✗ Tidak'; ?></td>
                        <td class="text-right" style="font-weight:bold;">Rp <?= number_format($premium->hitungTotalBiaya(), 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- ================= TABEL KATEGORI EVENT ================= -->
    <h2><span class="badge badge-event">Kategori</span> Paket Event</h2>
    <table>
        <thead>
            <tr>
                <th>ID Reservasi</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal Booking</th>
                <th>Durasi (Jam)</th>
                <th>Tarif / Jam</th>
                <th>Lokasi Luar</th>
                <th>Biaya Transportasi Tim</th>
                <th>Total Biaya (+ Akomodasi Luar)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($daftarEvent)): ?>
                <tr><td colspan="8" style="text-align:center;">Tidak ada data paket event.</td></tr>
            <?php else: ?>
                <?php foreach ($daftarEvent as $event): ?>
                    <?php 
                    $ref = new ReflectionClass($event);
                    $props = [];
                    foreach ($ref->getParentClass()->getProperties() as $p) {
                        $p->setAccessible(true);
                        $props[$p->getName()] = $p->getValue($event);
                    }
                    foreach ($ref->getProperties() as $p) {
                        $p->setAccessible(true);
                        $props[$p->getName()] = $p->getValue($event);
                    }
                    ?>
                    <tr>
                        <td><?= $props['idReservasi']; ?></td>
                        <td><?= $props['namaPelanggan']; ?></td>
                        <td><?= date('d-m-Y', strtotime($props['tanggalBooking'])); ?></td>
                        <td><?= $props['durasiJam']; ?> Jam</td>
                        <td class="text-right">Rp <?= number_format($props['tarifDasarPerJam'], 0, ',', '.'); ?></td>
                        <td><?= $props['namaLokasiLuar']; ?></td>
                        <td class="text-right">Rp <?= number_format($props['biayaTransportasiTim'], 0, ',', '.'); ?></td>
                        <td class="text-right" style="font-weight:bold;">Rp <?= number_format($event->hitungTotalBiaya(), 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>

<?php
// Tutup Koneksi Database
$conn->close();
?>