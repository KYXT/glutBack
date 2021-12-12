<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'lang',
        'slug',
        'name',
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function topics()
    {
        return $this->hasMany(ForumTopic::class, 'category_id');
    }
}
