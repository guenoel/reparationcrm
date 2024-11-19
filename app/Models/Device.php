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
        return self::pluck('id', 'id');
    }
}
