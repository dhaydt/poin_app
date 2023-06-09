<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoinHistory extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'admin_id', 'outlet_id', 'no_receipt', 'type','poin', 'pembelian', 'isredeem', 'isexpired', 'isreset'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }
    
    public function outlet(){
        return $this->belongsTo(Outlet::class);
    }

    // public function canAccessFilament(): bool
    // {
    //     return $this->hasRole(['karyawan']);
    // }
}
