<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $fillable = ['image', 'user_id', 'brand', 'model_name', 'model_number', 'serial_number', 'imei', 'description', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
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
