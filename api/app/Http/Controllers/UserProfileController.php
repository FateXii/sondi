<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserProfileResource;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /**
         * @var App\Models\User $user  
         */
        $user = Auth::user();
        if (!$user && ($user->isTenant() && !$user->isAdmin())) {
            return response()->json(['message' => 'Unauthorized', 'user' => $user], Response::HTTP_UNAUTHORIZED);
        } else if ($user->isAdmin()) {
            return UserProfileResource::collection(
                (UserProfile::orderByDesc('created_at')->paginate(25))
            );
        } else {
            return UserProfileResource::collection(
                (UserProfile::where('is_tenant', true)->orderByDesc('created_at')->paginate(25))
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function show($userProfile)
    {
        /**@var App\Models\User $user  */
        $user = Auth::user();
        if (
            $user &&
            ($user->isAdmin() ||
                $user->id ===  $userProfile->id ||
                ($user->isAgent() && $userProfile->is_tenant))
        ) {
            $userProfile = UserProfile::where('id', $userProfile)->first();
            return new UserProfileResource($userProfile);
        }
        return Response::HTTP_UNAUTHORIZED;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $userProfile)
    {
        /**@var App\Models\User $user  */
        $user = Auth::user();
        $request->validate([
            'is_admin' => 'boolean',
            'is_agent' => 'boolean',
            'agent_registration_number' => 'string',
            'is_tenant' => 'boolean',
            'photo' => 'image',
            'bio' => 'string',
            'phone_number' => 'string',
            'deleted_at' => 'date'
        ]);

        $userProfile = UserProfile::where('id', $userProfile)->first();
        if (
            $user->id === $userProfile->user_id ||
            $user->isAdmin()
        ) {
            $photo = $userProfile->photo;
            if ($request->hasFile('photo')) {
                if ($photo) {
                    Storage::delete($photo);
                }
                $photo = env('APP_URL') . '\/storage\/' . $request->file('photo')->store('images', 'public');
            }

            $fields = [
                'agent_registration_number',
                'is_admin',
                'is_agent',
                'is_tenant',
                'bio',
                'phone_number',
                'deleted_at'
            ];
            foreach ($fields as $field) {
                if ($request->filled($field)) {
                    $userProfile[$field] = $request[$field];
                }
            }

            $userProfile->photo = $photo;
            $userProfile->save();

            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        return  response()->json(["message" => "Unauthourized"], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy($userProfile)
    {
        $userProfile = UserProfile::where('id', $userProfile)->first();
        /**@var App\Models\User $user  */
        $user = Auth::user();
        if (!$user || $user->isTenant()) {
            return response()->json(['message' => 'Unauthorized',], Response::HTTP_UNAUTHORIZED);
        } else if ($user->isAdmin()) {
            $userProfile->delete();
        } else {
            $userProfile->delete();
        }
        if (!UserProfile::where('id', $userProfile)->first()) {
            return Response::HTTP_NO_CONTENT;
        } else {
            return Response::HTTP_BAD_REQUEST;
        }
    }
}
