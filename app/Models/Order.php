<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'destiny',
        'going_date',
        'back_date',
        'status',
        'id_user'
    ];
    public function status(): Attribute
    {
        return Attribute::make(
            set: fn(OrderStatus $status) => $status->name,
        );
    }
}
