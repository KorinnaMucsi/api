<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            //It was asked to be description instead of the original database field name - detail
            'description' => $this->detail,
            'price' => $this->price,
            'discount' => $this->discount,
            'stock' => $this->stock
        ];
    }
}
