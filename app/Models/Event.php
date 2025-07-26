<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Organizer;
use App\Models\Region;
use App\Models\City;
use App\Models\Categorie;
use App\Models\Event_stats;
use App\Models\Event_version;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'organizer_name',
        'title',
        'description',
        'region_id',
        'city_id',
        'category_id',
        'date',
        'time',
        'place',
        'image',
        'status',
    ];

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function stats()
    {
        return $this->hasOne(Event_stats::class);
    }

    public function versions()
    {
        return $this->hasMany(Event_version::class);
    }

    // Add this static function to update event statuses to 'passed' if their date/time is in the past
    public static function updatePassedEvents()
    {
        $now = now();
        $events = self::whereNotIn('status', ['passed', 'canceled'])->get();
        foreach ($events as $event) {
            $eventDateTime = \Carbon\Carbon::parse($event->date . ' ' . $event->time);
            if ($eventDateTime->isPast()) {
                $event->status = 'passed';
                $event->save();
            }
        }
    }
}
