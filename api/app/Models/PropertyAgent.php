<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAgent extends Model
{
    use HasFactory;
    protected $fillable = [
        'agent_id',
        'property_id'
    ];
}
