<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersNotification extends Model
{
    protected $table = 'users_notification';
    protected $primaryKey = 'notif_id';
    
    protected $fillable = [
        'user_id', 'pesan', 'dibaca', 'created_at',
    ];
}
