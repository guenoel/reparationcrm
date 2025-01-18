<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Device extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $fillable = ['image', 'user_id', 'brand', 'model_name', 'model_number', 'serial_number', 'imei', 'description', 'returned', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
    public function hasService(): bool
    {
        return $this->services()->exists(); // Vérifie si des services existent pour ce device
    }

    protected $appends = ['has_service'];
    public function getHasServiceAttribute(): bool
    {
        return $this->services()->exists();
    }

    public static function getDevicesForDropdown()
    {
        return self::select('devices.id', 'devices.user_id', 'devices.brand', 'devices.model_name', 'users.name', 'devices.serial_number')
            ->join('users', 'users.id', '=', 'devices.user_id') // Join with users table
            ->get()
            ->mapWithKeys(function ($device) {
                return [
                    $device->id => $device->name . ' / ' . $device->brand . ' / ' . $device->model_name . ' / ' . $device->serial_number, // Use user name
                ];
            });
    }
}
