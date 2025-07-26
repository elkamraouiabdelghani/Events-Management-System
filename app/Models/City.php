<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Region;
use App\Models\Event;
use App\Models\Event_version;
use App\Models\Organizer_historic;
use App\Models\Canceled_event;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'region_id',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function eventVersions()
    {
        return $this->hasMany(Event_version::class);
    }

    public function organizerHistorics()
    {
        return $this->hasMany(Organizer_historic::class);
    }

    public function canceledEvents()
    {
        return $this->hasMany(Canceled_event::class);
    }
}
