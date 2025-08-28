<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'barang';
    protected $fillable = [
        'id',
        'nama_barang',
        'harga'
    ];

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_barang');
    }
}
