<?php

namespace App\Models;

use App\Events\NewUserCreated;
use App\Listeners\SendNewUserNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotentialUser extends Model
{
    use HasFactory;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => NewUserCreated::class
    ];

    /**
     * Attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'email',
        'is_admin',
        'is_agent',
        'is_tenant'
    ];
}
