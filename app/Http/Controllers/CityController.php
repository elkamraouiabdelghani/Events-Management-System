<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Requests\CityRequest;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $cities = City::with('region')->get();
            $regions = Region::all();
        } catch (\Exception $e) {
            return redirect()->route('cities')->with('error', 'Une erreur est survenue lors de la récupération des villes.');
        }

        return view('parametres.cities.cities', compact('cities', 'regions'));
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
    public function store(CityRequest $request)
    {
        try{
            $request->validated();

            City::create([
                'name' => $request->name,
                'region_id' => $request->region_id,
            ]);

            return redirect()->route('cities')->with('success', 'Ville créée avec succès');
        } catch (\Exception $e) {
            return redirect()->route('cities')->with('error', 'Une erreur est survenue lors de la création de la ville.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CityRequest $request, City $city)
    {
        try{
            $request->validated();

            $city->update([
                'name' => $request->name,
                'region_id' => $request->region_id,
            ]);

            return redirect()->route('cities')->with('success', 'Ville mise à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->route('cities')->with('error', 'Une erreur est survenue lors de la modification de la ville.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        try {
            // Check if city has related events
            if ($city->events()->count() > 0) {
                return redirect()->route('cities')->with('error', 'Impossible de supprimer cette ville car elle contient des événements associés.');
            }

            // Check if city has related event versions
            if ($city->eventVersions()->count() > 0) {
                return redirect()->route('cities')->with('error', 'Impossible de supprimer cette ville car elle contient des versions d\'événements associées.');
            }

            // Check if city has related organizer historics
            if ($city->organizerHistorics()->count() > 0) {
                return redirect()->route('cities')->with('error', 'Impossible de supprimer cette ville car elle contient des historiques d\'organisateurs associés.');
            }

            // Check if city has related canceled events
            if ($city->canceledEvents()->count() > 0) {
                return redirect()->route('cities')->with('error', 'Impossible de supprimer cette ville car elle contient des événements annulés associés.');
            }

            // If no related data, delete the city
            $city->delete();

            return redirect()->route('cities')->with('success', 'Ville supprimée avec succès');
        } catch (\Exception $e) {
            return redirect()->route('cities')->with('error', 'Une erreur est survenue lors de la suppression de la ville.');
        }
    }
}
