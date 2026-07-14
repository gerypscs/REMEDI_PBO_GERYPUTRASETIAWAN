<?php

abstract class Reservasi
{
    // Properti terenkapsulasi dengan akses protected
    // Dipetakan menggunakan camelCase dari kolom database tahap 1
    protected string $idReservasi;
    protected string $namaPelanggan;
    protected string $tanggalBooking; // Dapat direpresentasikan sebagai string format YYYY-MM-DD
    protected int $durasiJam;
    protected float $tarifDasarPerJam;

    /**
     * Constructor untuk inisialisasi atribut global (induk)
     */
    public function __construct(
        string $idReservasi,
        string $namaPelanggan,
        string $tanggalBooking,
        int $durasiJam,
        float $tarifDasarPerJam
    ) {
        $this->idReservasi = $idReservasi;
        $this->namaPelanggan = $namaPelanggan;
        $this->tanggalBooking = $tanggalBooking;
        $this->durasiJam = $durasiJam;
        $this->tarifDasarPerJam = $tarifDasarPerJam;
    }

    /**
     * Menghitung total biaya berdasarkan logika spesifik tiap jenis paket.
     * Wajib diimplementasikan oleh class anak.
     * 
     * @return float
     */
    abstract public function hitungTotalBiaya(): float;

    /**
     * Menampilkan detail spesifikasi paket (atribut spesifik anak).
     * Wajib diimplementasikan oleh class anak.
     * 
     * @return void
     */
    abstract public function tampilkanSpesifikasiPaket(): void;
}