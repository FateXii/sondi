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
                'name' => ['required', 'string', 'max:255'],
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
            ['exists' => 'The :attribute email is not registered contact Sondi admin']
        )->validate();


        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
        $potentialUser = PotentialUser::where('email', $input['email'])->first();

        UserProfile::create([
            'email' => $input['email'],
            'user_id' => $user->id,
            'is_admin' => $potentialUser->is_admin,
            'is_agent' => $potentialUser->is_agent,
            'is_tenant' => $potentialUser->is_tenant,
        ]);
        $potentialUser->delete();

        return $user;
    }
}
