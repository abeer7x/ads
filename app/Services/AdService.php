<?php

namespace App\Services;

use App\Jobs\SendAdConfirmationEmail;
use App\Models\Ad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AdService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    // return all active ads and the count of review , the mainImage, user, and category
        public function all()
    {
         $ads =Cache::remember('active_ads', 600, function () {
        return Ad::activeAds()
            ->withCount('reviews')
            ->with(['mainImage', 'user', 'category'])
            ->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })
            ->get();
    });


         $ads->each(function($ad) {
        $ad->formatted_price;
        $ad->formatted_created_at;
    });
    return $ads;
    }
    public function getUserAds($userId)
{
    return Ad::where('user_id', $userId)
             ->activeAds()
             ->withCount('reviews')
             ->with(['mainImage', 'category'])
             ->get();
}

       public function create(array $data)
    {
        $data['status'] = 'pending';
          $data['user_id'] = Auth::id(); 
        $ad= Ad::create($data);
        if ($ad->wasRecentlyCreated) {
            Log::info('Ad was recently created: ID ' . $ad->id);
        }

         if (isset($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $path) {
                $ad->images()->create(['path' => $path]);
            }
        }

        return $ad;

    }

    public function update(Ad $ad, array $data): Ad
    {
        $ad->update($data);
        if ($ad->isDirty()) {
            Log::warning('Ad is still dirty after update.');
        }

        if (isset($data['images']) && is_array($data['images'])) {
            $ad->images()->delete();
            foreach ($data['images'] as $path) {
                $ad->images()->create(['path' => $path]);
            }
        }

        return $ad;
    }

    public function delete(Ad $ad): void
    {
         $ad->images()->delete();
        $ad->delete();
    }

    public function approve(Ad $ad)
    {
        $ad->update(['status' => 'active']);
         SendAdConfirmationEmail::dispatch($ad);

    }

    public function reject($id): void
    {
        $ad = Ad::with(['images', 'reviews'])->findOrFail($id);
        $ad->update(['status' => 'rejected']);
    }
}
