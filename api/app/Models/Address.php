<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
  use HasFactory;

  protected $fillable = [
    'street',
    'city',
    "province",
    "postal_code",
    "sectionals_id",
  ];

  public function property()
  {
    return $this->belongsTo(Property::class);
  }
  public function sectionals()
  {
    return $this->belongsTo(Sectionals::class);
  }
  public function unit()
  {
    return $this->sectionals !== null
      ?
      $this->sectionals
      ->sectional_units
      ->where('property_id', $this->property->id)
      ->first()->unit
      : null;
  }
}
