<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'transaksi';
    protected $fillable = [
        'id',
        'id_santri',
        'id_pegawai',
        'jenis',
        'total',
        'saldo_awal',
        'saldo_akhir',
        'tanggal_transaksi',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'id_santri');
    }

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}
