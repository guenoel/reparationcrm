<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Service extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $fillable = ['device_id', 'description', 'price', 'accepted', 'created_at', 'updated_at'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
    public function tasks()
    {
        return $this->hasMany(Service::class);
    }
    public function spares()
    {
        return $this->hasMany(Service::class);
    }
    public static function getServicesForDropdown()
    {
        return self::pluck('id', 'id');
    }
}
