<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumTopic extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'text',
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function category()
    {
        return $this->belongsTo(ForumCategory::class, 'id');
    }
    
    public function messages()
    {
        return $this->hasMany(ForumMessage::class, 'topic_id');
    }
}
