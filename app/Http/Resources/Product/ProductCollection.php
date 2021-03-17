<?php

namespace App\Http\Resources\Product;
//we use JsonResource instead of ResourceCollection
//use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
//class ProductCollection extends ResourceCollection
class ProductCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //We need the name, the total price, rating, discount for the product list only. 
        //The full description of the product is found on the href->link provided on the list.
        //The calculations are the same as in the unique product resource file (ProductResource)
        return [
            'name' => $this->name,
            'totalPrice' => ($this->discount != 0 && !is_null($this->discount)) ? round((1-$this->discount/100) * $this->price,2) : $this->price,
            'rating' => ($this->reviews->count() > 0) ? round($this->reviews->sum('star')/$this->reviews->count(),2) : 'No rating yet',
            'discount' => $this->discount,
            'href' => [
                'link' => route('products.show', $this->id)
            ]
        ];
    }
}
