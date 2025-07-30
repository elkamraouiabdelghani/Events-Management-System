<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Categorie;
use App\Models\Region;
use App\Models\City;
use App\Models\Organizer;
use App\Models\Canceled_event;
use App\Models\Event_version;
use App\Models\Organizer_historic;
use App\Mail\RequestUpdateEvent;
use App\Mail\EventCanBeEdited;
use Illuminate\Http\Request;
use App\Mail\EventPublished;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EventRequest;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            Event::updatePassedEvents();
            if(Auth::user()->role === 'admin'){
                $events = Event::orderBy('created_at', 'desc')->paginate(10);
            }else{
                $events = Event::where('organizer_id', Auth::user()->organizer->id)->orderBy('created_at', 'desc')->paginate(10);
            }
            return view('events.events', compact('events'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $categories = Categorie::all();
            $regions = Region::with('cities')->get();
            $cities = City::all();

            return view('events.create', compact('categories', 'regions', 'cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request)
    {
        try {
            $request->validated();

            $organizerId = null;
            if (auth()->user()->role === 'admin') {
                // Create a new organizer with just the title
                $organizer = Organizer::create([
                    // 'user_id' => 0,
                    'title' => $request->organizer_title,
                ]);
                $organizerId = $organizer->id;

                // Handle image upload
                $imageName = null;
                if ($request->hasFile('event_image')) {
                    $image = $request->file('event_image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images/events'), $imageName);
                }

                $event = new Event([
                    'organizer_id' => $organizerId,
                    'organizer_name' => $request->organizer_title,
                    'title' => $request->title,
                    'description' => $request->description,
                    'category_id' => $request->category_id,
                    'region_id' => $request->region_id,
                    'city_id' => $request->city_id,
                    'date' => $request->date,
                    'time' => $request->time,
                    'place' => $request->place,
                    'image' => $imageName,
                    'status' => 'new'
                ]);
                $event->save();

                return redirect()->route('events')->with('success', 'Événement créé avec succès');
                
            } elseif (auth()->user()->role === 'organizer' && auth()->user()->organizer) {
                $organizerId = auth()->user()->organizer->id;
            
                // Handle image upload
                $imageName = null;
                if ($request->hasFile('event_image')) {
                    $image = $request->file('event_image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images/events'), $imageName);
                }

                $event = new Event([
                    'organizer_id' => $organizerId,
                    'organizer_name' => auth()->user()->organizer->title,
                    'title' => $request->title,
                    'description' => $request->description,
                    'category_id' => $request->category_id,
                    'region_id' => $request->region_id,
                    'city_id' => $request->city_id,
                    'date' => $request->date,
                    'time' => $request->time,
                    'place' => $request->place,
                    'image' => $imageName,
                    'status' => 'new'
                ]);
                $event->save();

                return redirect()->route('events')->with('success', 'Événement créé avec succès');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        try {
            $categories = Categorie::all();
            $regions = Region::with('cities')->get();
            $cities = City::all();

            return view('events.event', compact('event', 'categories', 'regions', 'cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        try {
            $request->validated();

            Event_version::create([
                'event_id' => $event->id,
                'version' =>  (Event_version::count() + 1),
                'organizer_id' => $event->organizer_id,
                'title' => $event->title,
                'description' => $event->description,
                'region_id' => $event->region_id,
                'city_id' => $event->city_id,
                'category_id' => $event->category_id,
                'date' => $event->date,
                'time' => $event->time,
                'place' => $event->place,
                'image' => $event->image,
                'status' => $event->status,
            ]);

            $organizer = Organizer::find($event->organizer_id);

            $imageName = $event->image;
            if ($request->hasFile('event_image')) {
                if ($event->image) {
                    // Delete from public/images/events
                    if (file_exists(public_path('images/events/' . $event->image))) {
                        unlink(public_path('images/events/' . $event->image));
                    }
                }
                // Ensure the directory exists
                if (!file_exists(public_path('images/events'))) {
                    mkdir(public_path('images/events'), 0755, true);
                }
                // Store new image
                $image = $request->file('event_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/events'), $imageName);
            }

            $event->update([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'region_id' => $request->region_id,
                'city_id' => $request->city_id,
                'date' => $request->date,
                'time' => $request->time,
                'place' => $request->place,
                'image' => $imageName,
                'status' => 'updated',
                'organizer_name' => $organizer->title,
            ]);

            return redirect()->route('events')->with('success', 'Événement mis à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Publish events.
     */
    public function updateStatus(Request $request, Event $event)
    {
        try {
            if($request->status === 'canceled'){
                $canceledEvent = Canceled_event::create([
                    'organizer_id' => $event->organizer_id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'region_id' => $event->region_id,
                    'city_id' => $event->city_id,
                    'category_id' => $event->category_id,
                    'date' => $event->date,
                    'time' => $event->time,
                    'place' => $event->place,
                    'image' => $event->image,
                    'status' => $event->status,
                    'created_at' => $event->created_at,
                    'updated_at' => $event->updated_at,
                ]);

                $event->delete();
                return redirect()->back()->with('success', 'Événement annulé avec succès');
            }elseif($request->status === 'updated'){
                $event->status = $request->status;
                $event->save();

                // Notify the organizer that they can now edit the event
                $organizer = $event->organizer;
                if ($organizer && $organizer->user && $organizer->user->email) {
                    Mail::to($organizer->user->email)->send(new EventCanBeEdited($event, $organizer));
                }
                return redirect()->back()->with('success', 'Événement peut être modifié maintenant');
            }else{
                $event->status = $request->status;
                $event->save();
    
                if ($request->status === 'publish' && $event->organizer_id) {
                    $organizer = $event->organizer;
                    if ($organizer && $organizer->user && $organizer->user->email) {
                        Mail::to($organizer->user->email)->send(new EventPublished($event, $organizer));
                    }
                }
                
                return redirect()->back()->with('success', 'Événement publié avec succès');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Request update event.
    */
    public function requestUpdate(Request $request, Event $event)
    {
        try {
            $adminEmail = config('mail.admin_email', 'admin@example.com');
            Mail::to($adminEmail)->send(new RequestUpdateEvent($event, $event->organizer));

            return redirect()->back()->with('success', 'Votre demande de modification a été envoyée à l\'administrateur.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Events passed.
    */
    public function eventsPassed()
    {
        try {
            Event::updatePassedEvents();
            $events = Event::where('status', 'passed')->get();

            foreach ($events as $event) {
                $organizer_historic = Organizer_historic::create([
                    'organizer_id' => $event->organizer_id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'region_id' => $event->region_id,
                    'city_id' => $event->city_id,
                    'category_id' => $event->category_id,
                    'date' => $event->date,
                    'time' => $event->time,
                    'place' => $event->place,
                    'image' => $event->image,
                    'status' => $event->status,
                    'created_at' => $event->created_at,
                    'updated_at' => $event->updated_at,
                ]);
                $event->delete();
            }

            if(Auth::user()->role == 'admin'){
                $events = Organizer_historic::paginate(10);
            }else{
                $events = Organizer_historic::where('organizer_id', Auth::user()->organizer->id)->paginate(10);
            }

            return view('events.eventsPassed', compact('events'));
        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Events canceled.
    */
    public function eventsCanceled()
    {
        try {
            if(Auth::user()->role === 'admin'){
                $events = Canceled_event::paginate(10);
            }else{
                $events = Canceled_event::where('organizer_id', Auth::user()->organizer->id)->paginate(10);
            }

            return view('events.eventsCanceled', compact('events'));
        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
