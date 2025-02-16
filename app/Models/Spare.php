<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Spare extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $fillable = ['image', 'service_id', 'sparetype_id', 'description', 'date_purchase', 'date_reception', 'date_return', 'created_at', 'updated_at', 'task_id'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function spareType()
    {
        return $this->belongsTo(SpareType::class);
    }
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    public static function getSparesForDropdown()
    {
        return self::pluck('description', 'id');
    }

}
