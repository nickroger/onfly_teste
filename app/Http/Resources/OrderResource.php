<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'destiny' => $this->destiny,
            'going_date' => $this->going_date,
            'back_date' => $this->back_date,
            'date_created' => Carbon::make($this->created_at)->format('Y-m-d'),
        ];
    }
}
