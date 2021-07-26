<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandAlone extends Model
{
  use HasFactory;

  public function property()
  {
    return $this->hasOne(Property::class);
  }

  public function address()
  {
    return $this->belongsTo(Address::class, 'addresses_id');
  }
}
