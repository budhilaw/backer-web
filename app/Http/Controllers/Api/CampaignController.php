<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampaignRequest;
use App\Http\Resources\CampaignResource;
use App\Http\Resources\CampaignImageResource;
use App\Http\Resources\CampaignSingleResource;
use App\Models\Campaign;
use App\Models\CampaignImage;
use App\Http\Requests\CampaignImageRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Config;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $limit = config('app.configApp.limitPaginate');
        $campaigns = Campaign::where('status', 1)->orderByDesc('created_at')->paginate($limit);
        return CampaignResource::collection($campaigns);
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
            $userId = Auth::id();
            $slug = Str::slug($request->name);

            $campaign = Campaign::query()->create([
                'user_id' => $userId,
                'name' => $request->name,
                'slug' => $slug,
                'excerpt' => $request->excerpt,
                'description' => $request->description,
                'perks' => $request->perks,
                'backer_count' => $request->backer_count,
                'goal_amount' => $request->goal_amount,
                'current_amount' => $request->current_amount
            ]);
            return new CampaignResource($campaign);
        }
        return new CampaignResource(null);
    }

    /**
     * Display the specified resource.
     *
     * @param Campaign $campaign
     * @return CampaignSingleResource
     */
    public function show(Campaign $campaign): CampaignSingleResource
    {
        $data = Campaign::with('images')->find($campaign->id);
        return new CampaignSingleResource($data);
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
     * List of all images on the campaign
     *
     * @param String campaignId
     * @return AnonymousResourceCollection
     */
    public function listImageCampaign(String $id): AnonymousResourceCollection
    {
        $campaign = Campaign::findOrFail($id);
        $campaignImages = $campaign->images;
        return CampaignImageResource::collection($campaignImages);
    }

    /**
     * Upload an image for campaign
     *
     * @param CampaignImageRequest $request
     * @param String $id
     * @return CampaignImageResource|JsonResponse
     */
    public function uploadImageCampaign(CampaignImageRequest $request, String $id)
    {
        $path = config('app.configApp.pathCampaign');
        $pathToFile = $request->file('image')->store($path,'public');
        $filename = $pathToFile;
        $imageCampaign = CampaignImage::query()
            ->create([
                'campaign_id' => $id,
                'file_name' => $filename,
                'is_primary' => 0,
            ]);
        return new CampaignImageResource($imageCampaign);

    }

    /**
     * Delete an campaign image
     *
     * @param String $id
     * @return JsonResponse
     */
    public function deleteImageCampaign(String $id): JsonResponse
    {
        $campaignImage = CampaignImage::findOrFail($id);
        $fullPath = storage_path() . '/app/public/' . $campaignImage->file_name;
        unlink($fullPath);
        $campaignImage->delete();
        return response()->json(['message' => 'Campaign Image data successfully deleted!'],200);
    }

    /**
     * Set campaign image as primary image
     *
     * @param String $id
     * @return JsonResponse
     */
    public function setPrimaryImageCampaign(String $id): JsonResponse
    {
        $campaignImage = CampaignImage::findOrFail($id);
        $primaryImage = $campaignImage->campaign->images->where('is_primary', 1)->first();
        if(isset($primaryImage)) {
            // remove existing primary image
            $primaryImage->is_primary = false;
            $primaryImage->save();
        }
        $campaignImage->is_primary = true;
        $campaignImage->save();
        return response()->json(['message' => 'Successfuly set campaign image to be a primary image!'],200);
    }
}
