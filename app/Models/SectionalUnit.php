<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionalUnit extends Model
{
  use HasFactory;

  public function sectionals()
  {
    return $this->belongsTo(Sectionals::class);
  }

  public function property()
  {
    return $this->hasOne(SectionalUnit::class);
  }
}
