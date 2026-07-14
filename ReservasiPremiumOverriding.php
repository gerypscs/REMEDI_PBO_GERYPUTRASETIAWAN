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

    /**
     * OVERRIDING: Menghitung total biaya dengan tambahan surcharge layanan penuh sebesar 20%
     */
    public function hitungTotalBiaya(): float 
    {
        return ($this->durasiJam * $this->tarifDasarPerJam) * 1.20;
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