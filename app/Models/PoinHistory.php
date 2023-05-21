<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoinHistory extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'admin_id', 'outlet_id', 'no_receipt', 'type','poin', 'pembelian'];
}
