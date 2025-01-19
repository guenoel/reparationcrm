<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Service extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        'device_id',
        'description',
        'accepted',
        'deposit',
        'deposit_paid',
        'price',
        'price_paid',
        'done',
        'created_at',
        'updated_at',
    ];

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
        return self::select(
                'services.id', 
                'services.device_id', 
                'devices.user_id', 
                'devices.brand', 
                'devices.model_name', 
                'devices.serial_number', 
                'users.name', 
                'services.description'
            )
            ->join('devices', 'devices.id', '=', 'services.device_id') // Join with devices table
            ->join('users', 'users.id', '=', 'devices.user_id') // Join with users table via devices
            ->get()
            ->mapWithKeys(function ($service) {
                return [
                    $service->id => $service->name . ' / ' 
                        . $service->brand . ' / ' 
                        . $service->model_name . ' / ' 
                        . $service->serial_number . ' / ' 
                        . $service->description, // Add service description
                ];
            });
    }

}
