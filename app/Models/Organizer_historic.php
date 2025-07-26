<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Organizer;
use App\Models\Region;
use App\Models\City;
use App\Models\Categorie;

class Organizer_historic extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
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
}
