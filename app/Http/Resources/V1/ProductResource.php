<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id_product_ext'=> $this->id_product_ext,
            'name'=> $this->name,
            'description'=> $this->description,
            'category'=> $this->category,
            'price'=> $this->price,
            'image'=> $this->image,
            'status' => $this->status,
        ];
    }
}
