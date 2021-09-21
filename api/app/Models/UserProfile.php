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
        'is_admin',
        'is_agent',
        'is_tenant',
        'photo',
        'bio',
        'phone_number',
        'user_id',
        'agent_registration_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        if ($this->is_agent) {
            return $this->belongsToMany(Property::class, 'property_agents', 'agent_id', 'property_id');
        }
        return null;
    }
}
