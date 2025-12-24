<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutboxNotification extends Model
{
    use HasFactory;

    protected $table = 'outbox_notifications';

    protected $fillable = [
        'title',
        'body',
        'audience',
        'user_id',
        'status',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];
}





