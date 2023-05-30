<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoinView extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ph_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function history(){
        return $this->belongsTo(PoinHistory::class, 'ph_id');
    }
}
