<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyImage extends Model
{
  use HasFactory;
  protected $table = "property_image";

  public function image()
  {
    return $this->belongsTo(Image::class);
  }

  public function property()
  {
    return $this->belongsTo(Property::class);
  }
}
