<?php

namespace App\Http\Controllers;

use App\Models\PotentialUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PotentialUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * @var \App\Models\User $user  
         */
        $user = Auth::user();
        $request->validate([
            'email' => 'required|email|unique:users,email|unique:potential_users,email',
            'name' => 'required|string',
            'is_admin' => 'required|boolean',
            'is_agent' => 'required|boolean',
            'is_tenant' => 'required|boolean',
            'agent_registration_number' => 'string|nullable',
            'bio' => 'string|nullable',
            'phone_number' => 'string|nullable|unique:potential_users,phone_number',
        ]);
        $potentialUser = new PotentialUser();
        if ($user && ($user->isAdmin() || $user->isAgent())) {
            $potentialUser->name = $request->name;
            $potentialUser->email = $request->email;
            $potentialUser->is_admin = $request->is_admin;
            $potentialUser->is_agent = $request->is_agent;
            $potentialUser->is_tenant = $request->is_tenant;
            $potentialUser->agent_registration_number = $request->agent_registration_number;
            $potentialUser->bio = $request->bio;
            $potentialUser->phone_number = $request->phone_number;
            $potentialUser->save();
            return response()->json([], Response::HTTP_CREATED);
        }
        return response()->json(['Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PotentialUser  $potentialUser
     * @return \Illuminate\Http\Response
     */
    public function show(PotentialUser $potentialUser)
    {
        return $potentialUser;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PotentialUser  $potentialUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PotentialUser $potentialUser)
    {
        $user = Auth::user();
        $request->validate([
            'email' => 'required|email|unique:users,email',

        ]);
        if ($user) {
            $potentialUser->email = $request['email'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PotentialUser  $potentialUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(PotentialUser $potentialUser)
    {
        $potentialUser->delete();
    }
}
