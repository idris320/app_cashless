<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Santri extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'santris';
    protected $fillable = [
        'id',
        'nama_santri',
        'alamat',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'id_wali',
        'status',
    ];

    public function wali(){        
        return $this->belongsTo(WaliSantri::class, 'id_wali'); 
    }

    public function kartu()
    {
        return $this->hasOne(Kartu::class, 'id_santri');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_santri');
    }

    
}
