<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
  use HasFactory;
  protected $table = 'property';

  public function property_images()
  {
    return $this->hasMany(PropertyImage::class);
  }

  public function images()
  {
    return $this->hasManyThrough(PropertyImage::class, Image::class);
  }

  public function sales()
  {
    return $this->hasOne(Sales::class);
  }

  public function rentals()
  {
    return $this->hasOne(Rentals::class);
  }

  public function sectionalUnit()
  {
    return $this->belongsTo(SectionalUnit::class, 'sectional_units_id');
  }

  public function standAlone()
  {
    return $this->belongsTo(StandAlone::class, 'stand_alones_id');
  }

  public function address()
  {
    return $this->belongsTo(Address::class, 'addresses_id');
  }
}
