<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotentialUser extends Model
{
    use HasFactory;

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
