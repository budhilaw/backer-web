<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        if($request->validated()) {
            $input = $request->all();
            $user->fill($input)->save();
            return response()->json(['message' => 'User data successfully updated!']);
        }
        return response()->json(['message' => 'Failed to update user data'], 400);
    }

    /**
     * Get avatar URL link
     *
     */
    public function avatar()
    {
        $user = Auth::user();
        if($user->avatar) {
            return response()->json(['avatar' => $user->avatar]);
        } else {
            return response()->json(['avatar' => $user->getAvatar()]);
        }
    }

    /**
     * Get list of campaigns from a user.
     *
     * @return AnonymousResourceCollection
     */
    public function campaigns(): AnonymousResourceCollection
    {
        $limit = config('app.configApp.limitPaginate');
        $user = Auth::user();

        if($user->role == 1) {
            $campaigns = Campaign::paginate($limit);
            return CampaignResource::collection($campaigns);
        }

        $userCampaigns = $user->campaigns()->paginate(5);
        return CampaignResource::collection($userCampaigns);
    }
}
