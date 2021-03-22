<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductNotBelongsToUser;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    //only index and show methods can be executed without authentication
    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_all = Product::paginate(10);
        //Make collection of the resource (ProductCollection is a JsonResource)
        return ProductCollection::collection($product_all);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product1 = new Product();
        $product1->name = $request->name;
        $product1->detail = $request->detail;
        $product1->price = $request->price;
        $product1->stock = $request->stock;
        $product1->discount = $request->discount;
        $product1->user_id = $request->user_id;

        $product1->save();

        return response(["data" => new ProductResource($product1)], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        //We check if the user has permission to update the product (product belongs to user)
        //If the user has permission, then the product is updated, else, a ProductNotBelongsToUser
        //exception is thrown
        $this->userHasPermission($product);
        $product->update($request->all());

        return response(['data'=>new ProductResource($product)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //We check if the user has permission to delete the product (product belongs to user)
        //If the user has permission, then the product is deleted, else, a ProductNotBelongsToUser
        //exception is thrown
        $this->userHasPermission($product);
        $product->delete();
        return response()->json(null, 204);
    }

    public function userHasPermission($product)
    {
        //Created ProductNotBelongsToUser exception (Exceptions\ProductNotBelongsToUser)
        //to stop the user from updating, deleting the product if he has not permission for it
        if (Auth::user()->id !== $product->user_id) {
            throw new ProductNotBelongsToUser();
        }
    }
}
