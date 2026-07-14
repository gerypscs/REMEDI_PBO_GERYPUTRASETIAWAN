<?php

require_once 'Reservasi.php';

class ReservasiPremium extends Reservasi 
{
    private int $kuotaTalentOrang;
    private bool $layananMakeup;

    public function __construct(
        string $idReservasi, 
        string $namaPelanggan, 
        string $tanggalBooking, 
        int $durasiJam, 
        float $tarifDasarPerJam, 
        int $kuotaTalentOrang, 
        bool $layananMakeup
    ) {
        parent::__construct($idReservasi, $namaPelanggan, $tanggalBooking, $durasiJam, $tarifDasarPerJam);
        $this->kuotaTalentOrang = $kuotaTalentOrang;
        $this->layananMakeup = $layananMakeup;
    }

    public function hitungTotalBiaya(): float 
    {
        $biayaMakeup = $this->layananMakeup ? 200000 : 0;
        return ($this->tarifDasarPerJam * $this->durasiJam) + $biayaMakeup;
    }

    public function tampilkanSpesifikasiPaket(): void 
    {
        echo "--- Spesifikasi Paket Premium ---\n";
        echo "Kuota Talent       : " . $this->kuotaTalentOrang . " Orang\n";
        echo "Layanan Makeup     : " . ($this->layananMakeup ? "Ya" : "Tidak") . "\n";
    }

    public function getQueryPremiumWithMakeup(): string 
    {
        return "SELECT id_reservasi, nama_pelanggan, tanggal_booking, kuota_talent_orang, layanan_makeup " .
               "FROM tabel_reservasi " .
               "WHERE jenis_paket = 'Premium' AND layanan_makeup = TRUE;";
    }
}