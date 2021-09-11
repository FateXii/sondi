<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
  use HasFactory;

  public function property()
  {
    return $this->belongsTo(Property::class);
  }
  public function sectional()
  {
    return $this->belongsTo(Sectionals::class);
  }
}
