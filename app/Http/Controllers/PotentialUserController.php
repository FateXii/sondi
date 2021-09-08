<?php

namespace App\Http\Controllers;

use App\Models\PotentialUser;
use Illuminate\Http\Request;
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
        $user = Auth::user();
        Validator::make($request, [
            'email' => [
                'required',
                'string',
                'email',
            ],
        ],
        )->validate();

        if ($user)
        return PotentialUser::create([
            'email' => $request['email'],
        ]);
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
        Validator::make($request, [
            'email' => [
                'required',
                'string',
                'email',
            ],
        ],
        )->validate();
        $potentialUser->email = $request['email'];
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
