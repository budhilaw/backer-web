<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadPhotoRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

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
     * Upload avatar
     *
     * @param UploadPhotoRequest $request
     * @param String $id
     * @return JsonResponse
     */
    public function uploadAvatar(UploadPhotoRequest $request, String $id): JsonResponse
    {
        $path = config('app.configApp.pathAvatar');
        $pathToFile = $request->file('image')->store($path,'public');
        $filename = $pathToFile;

        $img = Image::make(storage_path() . '/app/public/' . $filename);
        $img->resize(160, 160);

        $tempPhoto = storage_path() . '/app/public/' . $filename;
        unlink($tempPhoto);

        $img->save(storage_path() . '/app/public/' . $filename);

        $user = User::findOrFail($id);

        if($user->avatar != "images/avatar/free.png") {
            $oldPhoto = storage_path() . '/app/public/' . $user->avatar;
            unlink($oldPhoto);
        }

        $user->avatar = $filename;
        $user->save();
        return response()->json($user);
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
            $campaigns = Campaign::orderByDesc('created_at')->paginate($limit);
            return CampaignResource::collection($campaigns);
        }

        $userCampaigns = $user->campaigns()->orderByDesc('created_at')->paginate(5);
        return CampaignResource::collection($userCampaigns);
    }
}
