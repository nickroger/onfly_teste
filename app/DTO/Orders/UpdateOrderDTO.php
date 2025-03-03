<?php

namespace App\DTO\Orders;

use App\Enums\OrderStatus;
use App\Http\Requests\StoreUpdateOrderRequest;

class UpdateOrderDTO
{
    public function __construct(
        public string $id,
        public string $destiny,
        public OrderStatus $status,
        public string $going_date,
        public string $back_date,
        public string $id_user,
    ) {}
    public static function makeFromRequest(StoreUpdateOrderRequest $request, string $id = null): self
    {
        return new  self(
            $id ?? $request->id,
            $request->destiny,
            OrderStatus::c,
            $request->going_date,
            $request->back_date,
            $request->id_user,
        );
    }
}
