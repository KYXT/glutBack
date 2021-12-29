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
        'is_open'
    ];
    
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function category()
    {
        return $this->belongsTo(ForumCategory::class, 'category_id');
    }
    
    public function messages()
    {
        return $this->hasMany(ForumMessage::class, 'topic_id');
    }
}
