<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['device_id', 'description', 'price', 'created_at', 'updated_at'];

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
