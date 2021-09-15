<?php

namespace App\Actions\Fortify;

use App\Models\PotentialUser;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make(
            $input,
            [
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class),
                    Rule::exists('potential_users', 'email')
                ],
                'password' => $this->passwordRules(),
            ],
            ['exists' => 'This email, is not registered. Please contact Sondi admin.']
        )->validate();


        $potentialUser = PotentialUser::where('email', $input['email'])->first();
        $user = User::create([
            'name' => $potentialUser->email,
            'email' => $potentialUser->name,
            'password' => Hash::make($input['password']),
        ]);

        UserProfile::create([
            'user_id' => $user->id,
            'is_admin' => $potentialUser->is_admin,
            'is_agent' => $potentialUser->is_agent,
            'is_tenant' => $potentialUser->is_tenant,
            'agent_registration_number' => $potentialUser->agent_registration_number,
            'photo' => $potentialUser->photo,
            'bio' => $potentialUser->bio,
            'phone_number' => $potentialUser->phone_number,
        ]);
        $potentialUser->delete();

        return $user;
    }
}
