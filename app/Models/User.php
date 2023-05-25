<?php

namespace App\Models;

use Filament\Forms\Components\Builder;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use KodePandai\Indonesia\Models\City;
use KodePandai\Indonesia\Models\Province;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'birthday',
        'outlet_id',
        'gender',
        'occupation',
        'province',
        'city',
        'address',
        'is_admin',
        'is_notify'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function province(){
        return $this->belongsTo(Province::class, 'province_id', 'code');
    }
    
    public function city(){
        return $this->belongsTo(City::class, 'city_id', 'code');
    }

    public function outlet(){
        return $this->belongsTo(Outlet::class);
    }

    public function canAccessFilament(): bool
    {
        return $this->hasRole(['admin','manager']);
    }
}
