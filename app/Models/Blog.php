<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'user_id',
        'published_at',
    ];

    protected $dates = [
        'published_at',
    ];
    protected $casts = [
        'published_at' => 'datetime',
    ];
    /**
     * Relasi ke penulis blog (user).
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
