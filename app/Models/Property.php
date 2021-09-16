<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
  use HasFactory;
  protected $table = 'property';

  public function address()
  {
    return $this->hasOne(Address::class);
  }
  public function images()
  {
    return $this->hasMany(Image::class);
  }
  public function sectional_unit()
  {
    return $this->hasOne(SectionalUnit::class);
  }
  public function agents()
  {
    return $this->belongsToMany(UserProfile::class, 'property_agents', 'property_id', 'agent_id');
  }
  public function features()
  {
    return $this->belongsToMany(Features::class, 'property_features', 'property_id', 'feature_id')
      ->withPivot('value');
  }
}
