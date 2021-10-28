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
class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CampaignResource::collection(Campaign::limit(9)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignRequest $request): JsonResponse
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
        return response()->json($request->errors(), 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        return new CampaignResource($campaign);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(CampaignRequest $request, Campaign $campaign)
    {
        $campaign->update($request->validated());
        return new CampaignResource($campaign);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return response()->noContent();
    }

    public function uploadImageCampaign(CampaignImageRequest $request)
    {
        $path = config('app.configApp.pathCampaign');
        $patToFile = $request->file('image')->store($path,'public');
        $filename = $patToFile;
        $imageCampaign = CampaignImage::query()
            ->create([
                'campaign_id' => $request->campaign_id,
                'file_name' => $filename,
                'is_primary' => $request->is_primary,
            ]);
        return new CampaignImageResource($imageCampaign);

    }
}
