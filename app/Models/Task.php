<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Task extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $fillable = ['image', 'service_id', 'user_id', 'start', 'stop', 'description', 'created_at', 'updated_at'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function spares()
    {
        return $this->hasMany(Spare::class);
    }
}
