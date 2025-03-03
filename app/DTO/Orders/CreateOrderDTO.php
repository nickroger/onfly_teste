<?php

namespace App\DTO\Orders;

use App\Enums\OrderStatus;
use App\Http\Requests\StoreUpdateOrderRequest;

class CreateOrderDTO
{
    public function __construct(
        public string $destiny,
        public OrderStatus $status,
        public string $going_date,
        public string $back_date,
        public string $id_user,
    ) {}
    public static function makeFromRequest(StoreUpdateOrderRequest $request): self
    {
        return new  self(
            $request->destiny,
            OrderStatus::r,
            $request->going_date,
            $request->back_date,
            $request->id_user,
        );
    }
}
