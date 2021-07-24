<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
  use HasFactory;
  protected $table = 'property';


  /**
   * Get the photos for a property
   */
  public function photos()
  {
    return $this->hasMany(Photo::class);
  }

  public function sales()
  {
    return $this->hasOne(Sales::class);
  }

  public function rentals()
  {
    return $this->hasOne(Rentals::class);
  }

  public function address()
  {
    return $this->hasOne(Address::class);
  }
}
