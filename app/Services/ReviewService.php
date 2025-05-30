<?php

namespace App\Services;

use App\Models\Review;

class ReviewService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
     public function all()
    {
        return Review::with(['user', 'ad'])->get();
    }
        public function create(array $data)
    {
        return Review::create($data);
    }

    public function update(Review $review, array $data)
    {
        $review->update($data);
        return $review;
    }

    public function delete(Review $review): void
    {
        $review->delete();
    }
}

