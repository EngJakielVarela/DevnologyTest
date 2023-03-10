<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'id_product'=> $this->id_product,
            'id_customer'=> $this->id_customer,
            'quantity'=> $this->quantity,
            'total' => $this->total,
            'status' => $this->status,
        ];
    }
}
