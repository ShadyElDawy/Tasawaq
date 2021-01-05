<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ProductNotBelongsToUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductsResource;
use App\Model\Product;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }

    public function index()
    {
        return ProductCollection::collection(Product::paginate(20));
    }


    public function store(ProductRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->details= $request->details;
        $product->price= $request->price;
        $product->stock= $request->stock;
        $product->discount= $request->stock;

        $product->save();

        return response(
            ['data' => new ProductResource($product)], Response::HTTP_CREATED); //using Response to class to send codes
    }


    public function show(Product $product)
    {
        return new ProductResource($product);
    }


    public function update(Request $request, Product $product)
    {
        $this->UserAuthCheck($product);
        $product->update($request->all());

        return response(
            ['data' => new ProductResource($product)], Response::HTTP_CREATED);

    }


    public function destroy(Product $product)
    {
        $this->UserAuthCheck($product);
        $product->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function UserAuthCheck($product){ // throws an exception if the logged in user id is not same as product user_id
        if( Auth::id() !== $product->user_id){
            throw new ProductNotBelongsToUser;
        }
    }
}
