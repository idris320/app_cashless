<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WaliSantri extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'walisantri';
    protected $fillable = [
        'id',
        'iduser',
        'nama',
        'alamat',
        'no_telp',
        'email',
    ];

    public function santri(){
    return $this->hasMany(Santri::class, 'id_wali');
    }
}
