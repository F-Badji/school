<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumGroup extends Model
{
    protected $fillable = ['name', 'description', 'created_by', 'avatar', 'restrict_messages'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'forum_group_user');
    }

    public function messages()
    {
        return $this->hasMany(ForumMessage::class)->orderBy('created_at', 'asc');
    }
}
