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
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function topic()
    {
        return $this->belongsTo(ForumTopic::class, 'id');        
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function reply()
    {
        return $this->belongsTo(ForumMessage::class, 'id');
    }
}
