<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //We need the customer, body (review) and the star fields to display reviews for a product
        return [
            'customer' => $this->customer,
            'body' => $this->review,
            'star' => $this->star
        ];
    }
}
