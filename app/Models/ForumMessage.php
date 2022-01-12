<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumMessage extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'topic_id',
        'user_id',
        'reply_id',
        'text',
    ];
    
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
    ];
    
    public function topic()
    {
        return $this->belongsTo(ForumTopic::class, 'topic_id');        
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function reply()
    {
        return $this->hasMany(ForumMessage::class, 'reply_id', 'id');
    }
    
    public function replies()
    {
        return $this->reply()->with('replies', 'user:id,name,email,role');
    }

    public function parent()
    {
        return $this->belongsTo(ForumMessage::class, 'reply_id');
    }
}
