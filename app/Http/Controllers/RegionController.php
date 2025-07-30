<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Requests\RegionRequest;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $regions = Region::all();
        } catch (\Exception $e) {
            return redirect()->route('regions')->with('error', 'Une erreur est survenue lors de la récupération des régions.');
        }

        return view('parametres.regions.regions', compact('regions'));
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
    public function store(RegionRequest $request)
    {
        try{
            $request->validated();

            Region::create($request->all());

            return redirect()->route('regions')->with('success', 'Région créée avec succès');
        } catch (\Exception $e) {
            return redirect()->route('regions')->with('error', 'Une erreur est survenue lors de la création de la région.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Region $region)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegionRequest $request, Region $region)
    {
        try{
            $request->validated();

            $region->update(['name' => $request->name]);

            return redirect()->route('regions')->with('success', 'Région mise à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->route('regions')->with('error', 'Une erreur est survenue lors de la modification de la région.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Region $region)
    {
        try {
            // Check if region has related cities
            if ($region->cities()->count() > 0) {
                return redirect()->route('regions')->with('error', 'Impossible de supprimer cette région car elle contient des villes associées.');
            }

            // Check if region has related events
            // if ($region->events()->count() > 0) {
            //     return redirect()->route('regions')->with('error', 'Impossible de supprimer cette région car elle contient des événements associés.');
            // }

            // Check if region has related event versions
            // if ($region->eventVersions()->count() > 0) {
            //     return redirect()->route('regions')->with('error', 'Impossible de supprimer cette région car elle contient des versions d\'événements associées.');
            // }

            // Check if region has related organizer historics
            // if ($region->organizerHistorics()->count() > 0) {
            //     return redirect()->route('regions')->with('error', 'Impossible de supprimer cette région car elle contient des historiques d\'organisateurs associés.');
            // }

            // Check if region has related canceled events
            // if ($region->canceledEvents()->count() > 0) {
            //     return redirect()->route('regions')->with('error', 'Impossible de supprimer cette région car elle contient des événements annulés associés.');
            // }

            // If no related data, delete the region
            $region->delete();

            return redirect()->route('regions')->with('success', 'Région supprimée avec succès');

        } catch (\Exception $e) {
            return redirect()->route('regions')->with('error', 'Une erreur est survenue lors de la suppression de la région.');
        }
    }
}
