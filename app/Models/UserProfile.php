<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use HasFactory, SoftDeletes;
       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agent_registration_number',
        'is_admin',
        'is_agent',
        'is_tenant',
        'photo',
        'bio',
        'phone_number',
        'deleted_at',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
