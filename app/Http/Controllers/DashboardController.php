<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Event;
use App\Models\Organizer;
use App\Models\Region;
use App\Models\City;
use App\Models\User;
use App\Models\Canceled_event;
use App\Models\Organizer_historic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics.
     */
    public function index(Request $request)
    {
        // Ensure event statuses are up to date
        Event::updatePassedEvents();
        // Get statistics data
        try {
            $categoriesCount = Categorie::count();
            $eventsCount = Event::count();
            $organizersCount = Organizer::count();
            $regionsCount = Region::count();
            $citiesCount = City::count();

            // Get all years with events
            if (Auth::user()->role == 'organizer') {
                $years = Event::where('organizer_id', Auth::user()->organizer->id)
                    ->selectRaw('YEAR(created_at) as year')
                    ->distinct()->orderBy('year', 'desc')->pluck('year');
            } else {
                $years = Event::selectRaw('YEAR(created_at) as year')
                    ->distinct()->orderBy('year', 'desc')->pluck('year');
            }
            $selectedYear = $request->input('year', now()->year);
            $selectedRegion = $request->input('region', '');

            // Get all regions for the dropdown
            $regions = Region::orderBy('name')->get();

            // Events per month for line graph (selected year and region)
            $months = collect(range(1, 12))->map(function ($i) use ($selectedYear) {
                return sprintf('%04d-%02d', $selectedYear, $i);
            });
            if (Auth::user()->role == 'organizer') {
                $futureEventsCount = Event::where('date', '>', now())
                        ->where('organizer_id', Auth::user()->organizer->id)
                        ->count();
                $passedEventsCount = Organizer_historic::where('organizer_id', Auth::user()->organizer->id)
                        ->count();
                $canceledEventsCount = Canceled_event::where('organizer_id', Auth::user()->organizer->id)
                        ->count();
                $newEvents = Event::where('status', 'new')
                        ->where('organizer_id', Auth::user()->organizer->id)
                        ->orderBy('created_at', 'desc')
                        ->paginate(4);
                
                // Build events per month query with region filter
                $eventsPerMonthQuery = Event::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                    ->where('organizer_id', Auth::user()->organizer->id)
                    ->whereYear('created_at', $selectedYear);
                
                if ($selectedRegion) {
                    $eventsPerMonthQuery->where('region_id', $selectedRegion);
                }
                
                $eventsPerMonth = $eventsPerMonthQuery->groupBy('month')->pluck('count', 'month');
            } else {
                $newEvents = Event::whereIn('status', ['new','updated'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(4);
                
                // Build events per month query with region filter
                $eventsPerMonthQuery = Event::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                    ->whereYear('created_at', $selectedYear);
                
                if ($selectedRegion) {
                    $eventsPerMonthQuery->where('region_id', $selectedRegion);
                }
                
                $eventsPerMonth = $eventsPerMonthQuery->groupBy('month')->pluck('count', 'month');
            }
            $eventsPerMonthData = $months->map(function($month) use ($eventsPerMonth) {
                return [
                    'month' => $month,
                    'count' => $eventsPerMonth[$month] ?? 0
                ];
            });
            if (Auth::user()->role == 'organizer') {
                return view('dashboard', compact(
                    'futureEventsCount',
                    'passedEventsCount',
                    'canceledEventsCount',
                    'newEvents',
                    'eventsPerMonthData',
                    'years',
                    'selectedYear',
                    'regions',
                    'selectedRegion'
                ));
            }
            return view('dashboard', compact(
                'categoriesCount',
                'eventsCount', 
                'organizersCount',
                'regionsCount',
                'citiesCount',
                'newEvents',
                'eventsPerMonthData',
                'years',
                'selectedYear',
                'regions',
                'selectedRegion'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error fetching statistics: ' . $e->getMessage());
        }
    }
} 