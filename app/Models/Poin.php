<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poin extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'poin', 'total_pembelian'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
