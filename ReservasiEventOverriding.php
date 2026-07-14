<?php

require_once 'Reservasi.php';

class ReservasiEvent extends Reservasi 
{
    private string $namaLokasiLuar;
    private float $biayaTransportasiTim;

    public function __construct(
        string $idReservasi, 
        string $namaPelanggan, 
        string $tanggalBooking, 
        int $durasiJam, 
        float $tarifDasarPerJam, 
        string $namaLokasiLuar, 
        float $biayaTransportasiTim
    ) {
        parent::__construct($idReservasi, $namaPelanggan, $tanggalBooking, $durasiJam, $tarifDasarPerJam);
        $this->namaLokasiLuar = $namaLokasiLuar;
        $this->biayaTransportasiTim = $biayaTransportasiTim;
    }

    /**
     * OVERRIDING: Menghitung total biaya durasi ditambah akomodasi/transportasi tim luar studio
     */
    public function hitungTotalBiaya(): float 
    {
        return ($this->durasiJam * $this->tarifDasarPerJam) + $this->biayaTransportasiTim;
    }

    public function tampilkanSpesifikasiPaket(): void 
    {
        echo "--- Spesifikasi Paket Event ---\n";
        echo "Lokasi Luar Studio : " . $this->namaLokasiLuar . "\n";
        echo "Transportasi Tim   : Rp " . number_format($this->biayaTransportasiTim, 0, ',', '.') . "\n";
    }

    public function getQueryByLokasi(string $lokasi): string 
    {
        return "SELECT id_reservasi, nama_pelanggan, tanggal_booking, nama_lokasi_luar, biaya_transportasi_tim " .
               "FROM tabel_reservasi " .
               "WHERE jenis_paket = 'Event' AND nama_lokasi_luar LIKE '%" . $lokasi . "%';";
    }
}