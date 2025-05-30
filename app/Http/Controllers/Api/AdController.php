<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ad\StoreAdRequest;
use App\Http\Requests\Ad\UpdateAdRequest;
use App\Models\Ad;
use App\Services\AdService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AdController extends Controller
{
    use AuthorizesRequests;

    protected $adService;

    public function __construct(AdService $adService)
    {
        $this->adService = $adService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $ads = $this->adService->all();

        return response()->json($ads);
    }
        public function userAds(Request $request)
    {
        $userId = $request->user()->id;

        $ads = $this->adService->getUserAds($userId);

        return response()->json($ads);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdRequest $request)
    {
        $ad = $this->adService->create($request->validated());

        return $this->success([
            'data' => $ad], 201);
    }

       public function approve(Request $request, Ad $ad)
    {
         $this->authorize('approve', $ad);
        $this->adService->approve($ad);

        return $this->success(['message' => 'تمت الموافقة على الإعلان.']);
    }

    public function reject($id)
    {
        $this->authorize('reject', Ad::class);
        $this->adService->reject($id);

        return $this->success(['message' => 'تم رفض الإعلان.']);
    }


    /**
     * Display the specified resource.
     */
    public function show(Ad $ad) 
    {
        $this->authorize('view', $ad);

        return $this->success($ad);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdRequest $request, Ad $ad) 
    {
        $this->authorize('update', $ad);

        $updatedAd = $this->adService->update($ad, $request->validated());

        return $this->success($updatedAd);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad) 
    {
        $this->authorize('delete', $ad);

        $this->adService->delete($ad);

        return $this->success(['message' => 'Ad deleted successfully']);
    }
}
