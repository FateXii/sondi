<?php

namespace App\Models;

use App\Events\NewMessageCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => NewMessageCreated::class
    ];
    protected $fillable = [
        "to",
        "from",
        "subject",
        "message",
        "type",
    ];
}
