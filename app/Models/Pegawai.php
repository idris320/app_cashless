<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory;
    use SoftDeletes;    

    protected $table = 'pegawais';
    protected $fillable = [
        'id',
        'nama_pegawai',
        'no_telp',
        'email',
        'alamat',
        'posisi',
    ];
    
}
