<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'lang',
        'slug',
        'title',
        'h1',
        'content',
        'image',
        'description',
        'keywords',
        'is_on_main'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * @return BelongsTo
     */
    public function category() :BelongsTo
    {
        return $this->belongsTo(PostCategory::class);
    }
}
