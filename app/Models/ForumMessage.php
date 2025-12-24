<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumMessage extends Model
{
    protected $fillable = ['forum_group_id', 'sender_id', 'content', 'label', 'read_at'];

    public function forumGroup()
    {
        return $this->belongsTo(ForumGroup::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
