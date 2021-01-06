<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Model\Product;
use App\Model\Review;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{

    public function index(Product $product)
    {
        return ReviewResource::collection($product->reviews); //we use collection because it's not a single review, but many
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request,Product $product)
    {
        $review = new Review($request->all()); //mass assigment needs $fillable in review model
        //$review->product_id = $product->id; //will be sent as param through url//working
        $product->reviews()->save($review);

        $review->save();
        return response(['data' => new ReviewResource($review)],Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Product $product,Review $review)
    {
        // we are passing three params as our POST route sends product id and review id
        //authorization of updating review is being handled from api consumer, he will handle the owner of review auth
        $review->update($request->all());
        return response(['data' => new ReviewResource($review)],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,Review $review)
    {
        $review->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
