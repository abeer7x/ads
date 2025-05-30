<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\review\StoreReviewRequest;
use App\Http\Requests\review\UpdateReviewRequest;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use AuthorizesRequests;
    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = $this->reviewService->all();

        return $this->success($reviews);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $this->authorize('create', Review::class);
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $review = $this->reviewService->create($data);

        return $this->success($review, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $this->authorize('view', $review);

        return $this->success($review);
    }

    /**
     * Update the specified resource in storage.
     */
  
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $this->authorize('update', $review);

        $updatedReview = $this->reviewService->update($review, $request->validated());

        return $this->success($updatedReview);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $this->reviewService->delete($review);

        return $this->success(['message' => 'Review deleted successfully']);
    }
}
