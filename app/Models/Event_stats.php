<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Event;

class Event_stats extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'views',
        'interestings',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
