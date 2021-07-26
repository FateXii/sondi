<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
  use HasFactory;

  public function sectionals()
  {
    return $this->hasOne(Sectionals::class);
  }

  public function standAlone()
  {
    return $this->hasOne(StandAlone::class);
  }
}
