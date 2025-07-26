<?php

namespace App\Http\Controllers;

use App\Models\Event_version;
use App\Models\Event;
use Illuminate\Http\Request;

class EventVersionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        try {
            $eventVersions = Event_version::where('event_id', $event->id)->get();

            return view('events.eventVersions', compact('eventVersions', 'event'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la récupération des versions de l\'événement');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Event_version $event_version)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event_version $event_version)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event_version $event_version)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event_version $event_version)
    {
        //
    }
}
