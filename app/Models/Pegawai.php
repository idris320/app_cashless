<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory;
    use SoftDeletes;    

    protected $table = 'pegawai';
    protected $fillable = [
        'id',
        'iduser',
        'nama_pegawai',
        'no_telp',
        'email',
        'alamat',
        'posisi',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'iduser');
    }
}
