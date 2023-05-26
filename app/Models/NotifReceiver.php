<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifReceiver extends Model
{
    use HasFactory;

    protected $fillable = ['notification_id', 'user_id', 'is_read'];

    public function notif(){
        return $this->belongsTo(Notifications::class, 'notification_id');
    }
}
