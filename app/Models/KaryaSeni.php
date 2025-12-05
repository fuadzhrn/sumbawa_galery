<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryaSeni extends Model
{
    use HasFactory;

    protected $table = 'karya_seni';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'deskripsi',
        'media_type',
        'media_path',
        'thumbnail',
        'status',
        'alasan_penolakan',
        'views',
        'likes',
    ];

    /**
     * Relationship: KaryaSeni belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: KaryaSeni belongs to Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Scope: Get only approved karya
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: Get only pending karya
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Get only rejected karya
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
