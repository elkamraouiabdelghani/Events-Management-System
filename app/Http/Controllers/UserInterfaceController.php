<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Categorie;
use App\Models\Region;
use App\Models\City;
use App\Models\Organizer;
// use Illuminate\Database\Eloquent\Collection;

class UserInterfaceController extends Controller
{
    public function index()
    {
        try {
            $events = Event::with(['organizer', 'category', 'city', 'region'])
                          ->where('status', 'publish')
                          ->where('date', '>=', now()->toDateString()) // Only future events
                          ->orderBy('date', 'asc')
                          ->orderBy('time', 'asc')
                          ->limit(6)
                          ->get();
            
            $categories = Categorie::all();
            $regions = Region::all();
            $cities = City::all();

            return view('userInterface.accueil', compact('events', 'categories', 'regions', 'cities'));
        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function events(Request $request)
    {
        try {
            $query = Event::with(['organizer', 'category', 'city', 'region'])
                        ->where('status', 'publish');

            // // Apply filters
            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }

            if ($request->filled('region')) {
                $query->where('region_id', $request->region);
            }

            if ($request->filled('city')) {
                $query->where('city_id', $request->city);
            }

            if ($request->filled('date')) {
                $query->whereDate('date', $request->date);
            }

            if ($request->filled('time')) {
                $query->whereTime('time', $request->time);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('place', 'like', "%{$search}%");
                });
            }

            $events = $query->orderBy('date', 'asc')
                           ->paginate(10);

            $categories = Categorie::all();
            $regions = Region::all();
            $cities = City::all();

            return view('userInterface.événements', compact('events', 'categories', 'regions', 'cities'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($event)
    {
        try {
            $event = Event::with(['organizer', 'category', 'city', 'region'])
                         ->findOrFail($event);
            
            // Get related events (same category, different events)
            $relatedEvents = Event::with(['organizer', 'category', 'city'])
                                 ->where('category_id', $event->category_id)
                                 ->where('status', 'published')
                                 ->limit(3)
                                 ->get();
            
            return view('userInterface.événement', compact('event', 'relatedEvents'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function contact()
    {
        $regions = Region::all();
        $categories = Categorie::all();
        return view('userInterface.contact', compact('regions', 'categories'));
    }
}
