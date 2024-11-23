<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpareType extends Model
{
    use HasFactory;
    protected $fillable = ['image', 'dealer', 'type', 'brand', 'description', 'buy_price', 'sell_price', 'created_at', 'updated_at'];

    public function spares()
    {
        return $this->hasMany(Spare::class);
    }

    public static function getSparetypesForDropdown()
    {
        return self::pluck('type', 'id');
    }
}
