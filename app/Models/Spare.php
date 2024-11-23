<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spare extends Model
{
    use HasFactory;
    protected $fillable = ['image', 'service_id', 'sparetype_id', 'description', 'date_purchase', 'date_reception', 'date_return', 'created_at', 'updated_at'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function spare_type()
    {
        return $this->belongsTo(SpareType::class);
    }

}
