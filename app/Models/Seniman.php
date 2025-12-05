<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seniman extends Model
{
    use HasFactory;

    protected $table = 'seniman';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'nama',
        'biografi',
        'foto',
        'jumlah_karya',
    ];

    /**
     * Relationship: Seniman belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Seniman belongs to Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Relationship: Seniman has many KaryaSeni (through user)
     */
    public function karyaSeni()
    {
        return $this->user->karyaSeni();
    }
}
