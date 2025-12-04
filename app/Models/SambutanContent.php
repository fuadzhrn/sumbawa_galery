<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SambutanContent extends Model
{
    use HasFactory;

    protected $table = 'sambutan_contents';

    protected $fillable = [
        'hero_image',
        'visi_image',
        'visi_text',
        'misi_image',
        'misi_text',
        'obj1_image',
        'obj1_title',
        'obj1_deskripsi',
        'obj2_image',
        'obj2_title',
        'obj2_deskripsi',
        'obj3_image',
        'obj3_title',
        'obj3_deskripsi',
        'obj4_image',
        'obj4_title',
        'obj4_deskripsi',
    ];

    /**
     * Get or create the default sambutan content
     */
    public static function getOrCreate()
    {
        return self::firstOrCreate(
            ['id' => 1],
            []
        );
    }
}
