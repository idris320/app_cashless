<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes; 
    
    protected $table = 'all_users'; 
    
    protected $fillable = [  
        'id',
        'username',               
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [            
            'password' => 'hashed',
        ];
    }


    public function pegawai()
    {
        return $this->hasOne(Pegawai::class, 'iduser');
      
    }

  
    public function waliSantri()
    {
        return $this->hasOne(WaliSantri::class, 'iduser');
    }


    public function getNamaAttribute()
    {
        if ($this->role === 'admin' && $this->pegawai) {
            return $this->pegawai->nama_pegawai;
        }

      
        if ($this->role === 'wali_santri' && $this->waliSantri) {
            return $this->waliSantri->nama_wali;
        }

        return 'Tidak ada nama';
    }


    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isWaliSantri(): bool
    {
   
        return $this->role === 'wali_santri'; 
    }
}