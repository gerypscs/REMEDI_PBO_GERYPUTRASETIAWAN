<?php

require_once 'Reservasi.php';

class ReservasiReguler extends Reservasi 
{
    private string $tipeBackground;
    private int $cetakFotoLembar;

    public function __construct(
        string $idReservasi, 
        string $namaPelanggan, 
        string $tanggalBooking, 
        int $durasiJam, 
        float $tarifDasarPerJam, 
        string $tipeBackground, 
        int $cetakFotoLembar
    ) {
        parent::__construct($idReservasi, $namaPelanggan, $tanggalBooking, $durasiJam, $tarifDasarPerJam);
        $this->tipeBackground = $tipeBackground;
        $this->cetakFotoLembar = $cetakFotoLembar;
    }

    public function hitungTotalBiaya(): float 
    {
        $biayaCetak = $this->cetakFotoLembar * 15000;
        return ($this->tarifDasarPerJam * $this->durasiJam) + $biayaCetak;
    }

    public function tampilkanSpesifikasiPaket(): void 
    {
        echo "--- Spesifikasi Paket Reguler ---\n";
        echo "Tipe Background    : " . $this->tipeBackground . "\n";
        echo "Jumlah Cetak Foto  : " . $this->cetakFotoLembar . " lembar\n";
    }

    public function getQueryByBackground(string $background): string 
    {
        return "SELECT id_reservasi, nama_pelanggan, tanggal_booking, tipe_background, cetak_foto_lembar " .
               "FROM tabel_reservasi " .
               "WHERE jenis_paket = 'Reguler' AND tipe_background = '" . $background . "';";
    }
}