<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampaignRequest;
use App\Http\Resources\CampaignResource;
use App\Http\Resources\CampaignImageResource;
use App\Models\Campaign;
use App\Models\CampaignImage;
use App\Http\Requests\CampaignImageRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Config;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return CampaignResource::collection(Campaign::limit(9)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CampaignRequest $request
     * @return CampaignResource
     */
    public function store(CampaignRequest $request): CampaignResource
    {
        if($request->validated()) {
            $campaign = Campaign::query()->create([
                'user_id' => $request -> user_id,
                'name' => $request -> name,
                'slug' => $request -> slug,
                'excerpt' => $request -> excerpt,
                'description' => $request -> description,
                'perks' => $request -> perks,
                'backer_count' => $request -> backer_count,
                'goal_amount' => $request -> goal_amount,
                'current_amount' => $request -> current_amount
            ]);
            return new CampaignResource($campaign);
        }
        return new CampaignResource(null);
    }

    /**
     * Display the specified resource.
     *
     * @param Campaign $campaign
     * @return CampaignResource
     */
    public function show(Campaign $campaign): CampaignResource
    {
        $data = Campaign::with('image')->find($campaign->id);
        return new CampaignResource($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param String $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $campaign = Campaign::findOrFail($id);
        $fields = $request->only($campaign->getFillable());
        $campaign->fill($fields);
        $campaign->save();
        return response()->json(['message' => 'Campaign data successfully updated!'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param String $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();
        return response()->json(['message' => 'Campaign data successfully deleted!'],200);
    }

    /**
     * Upload an image for campaign
     *
     * @param CampaignImageRequest $request
     * @return CampaignImageResource
     */
    public function uploadImageCampaign(CampaignImageRequest $request): CampaignImageResource
    {
        $path = config('app.configApp.pathCampaign');
        $pathToFile = $request->file('image')->store($path,'public');
        $filename = $pathToFile;
        $imageCampaign = CampaignImage::query()
            ->create([
                'campaign_id' => $request->campaign_id,
                'file_name' => $filename,
                'is_primary' => $request->is_primary,
            ]);
        return new CampaignImageResource($imageCampaign);

    }
}
