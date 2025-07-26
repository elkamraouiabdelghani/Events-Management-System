<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Event;
use App\Models\Event_version;
use App\Models\Organizer_historic;
use App\Models\Canceled_event;

class Organizer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'phone_numbre',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
