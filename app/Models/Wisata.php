<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    use HasFactory;

    // Tambahkan baris ini jika nama tabel di database Anda adalah 'wisata'
    protected $table = 'wisata'; 

    protected $fillable = [
        'nama',
        'kategori_id',
        'harga_tiket',
        'kuota_harian',
        'foto',
        'deskripsi',
        'alamat',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}