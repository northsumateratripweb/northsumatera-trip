<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripData extends Model
{
    protected $fillable = [
        'tanggal',
        'nama_pelanggan',
        'status',
        'nomor_hp',
        'nama_driver',
        'layanan',
        'plat_mobil',
        'jenis_mobil',
        'drone',
        'jumlah_hari',
        'penumpang',
        'hotel_1',
        'hotel_2',
        'hotel_3',
        'hotel_4',
        'harga',
        'deposit',
        'pelunasan',
        'tiba',
        'flight_balik',
        'notes',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tiba' => 'date',
        'drone' => 'boolean',
        'jumlah_hari' => 'integer',
        'penumpang' => 'integer',
        'harga' => 'decimal:2',
        'deposit' => 'decimal:2',
        'pelunasan' => 'decimal:2',
    ];
}
