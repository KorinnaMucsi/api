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
            //if stock is null, or 0, the value should be Out of stock
            'stock' => ($this->stock == 0 || is_null($this->stock)) ? 'Out of stock' : $this->stock,
            //we calculate the average rating if there is at least on rating given for the product
            //(rating: sum of the stars given/total number of stars)
            'rating' => ($this->reviews->count() > 0) ? round($this->reviews->sum('star')/$this->reviews->count(),2) : 'No rating yet',
            //we calculate the totalPrice based on the discount
            'totalPrice' => ($this->discount != 0 && !is_null($this->discount)) ? round((1-$this->discount/100) * $this->price,2) : $this->price,
            'href' => [
                'reviews' => route('reviews.index', $this->id)
            ]
        ];
    }
}
