<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserProfileResource;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /**@var App\Models\User $user  */
        $user = Auth::user();
        if (!$user || $user->isTenant()){
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        else if ($user->isAdmin()){
            return UserProfileResource::collection(
                ( UserProfile::orderByDesc('created_at')->paginate(25))
            );   
        } else {
            return UserProfileResource::collection(
                ( UserProfile::where('is_tenant', true)->orderByDesc('created_at')->paginate(25))
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
    public function show(UserProfile $userProfile)
    {
        /**@var App\Models\User $user  */
        $user = Auth::user();
        if (
            $user &&
            (
                $user->isAdmin() ||
                $user->id ===  $userProfile->id ||
                ($user->isAgent() && $userProfile->is_tenant)
            )
        ){
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
    public function update(Request $request, UserProfile $userProfile)
    {
        $user = Auth::user();
        Validator::make($request,[ 
            'agent_registration_number' => [
                'string',
                Rule::unique(UserProfile::class)
            ],
            'is_admin' => ['boolean',],
            'is_agent'=> ['boolean',],
            'is_tenant'=> ['boolean'],
            'photo' => ['image'],
            'bio' => ['string'],
            'phone_number' => ['string',],
            'deleted_at' => ['date']
        ])->validate();

        if ($user->id === $userProfile->user_id) {
            $userProfile->update([
                'agent_registration_number' => $request['agent_registration_number'],
                'is_admin' => $request['is_admin'],
                'is_agent'=> $request['is_agent'],
                'is_tenant'=> $request['is_tenant'],
                'photo' => $request->hasFile('photo') ?
                    $request->file('photo')->store('images', 'public') : 
                    null,
                'bio' => $request['bio'],
                'phone_number' => $request['phone_number'],
                'deleted_at' => $request['deleted_at'],
            ]);
            return Response::HTTP_NO_CONTENT;
        }
        return  response()->json(["message" => "Unauthourized"], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserProfile $userProfile)
    {
        /**@var App\Models\User $user  */
        $user = Auth::user();
        if (!$user || $user->isTenant()){
            return response()->json(['message' => 'Unauthorized',], Response::HTTP_UNAUTHORIZED);
        }
        else if ($user->isAdmin()){
            $userProfile->delete();
        } else {
            $userProfile->delete();
        }
        return Response::HTTP_NO_CONTENT;
    }
}
