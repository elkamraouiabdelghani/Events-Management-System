<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Mail\OrganizerAccountCreated;
use Illuminate\Support\Str;

class OrganizerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $organizers = Organizer::all();
            return view('organizers.organizers', compact('organizers'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la récupération des organisateurs');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $organizers = Organizer::whereNull('user_id')->get();

            return view('organizers.create', compact('organizers'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création de l\'organisateur');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            if(is_null($request->existing_organizer_id)){
                $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|string|min:8',
                    'title' => 'required|string|max:255',
                    'phone_numbre' => 'nullable|string|max:10',
                    'description' => 'nullable|string|max:255',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ],[
                    'name.required' => 'Le nom est requis',
                    'email.required' => 'L\'email est requis',
                    'email.email' => 'L\'email doit être une adresse email valide',
                    'email.unique' => 'L\'email existe déjà',
                    'password.required' => 'Le mot de passe est requis',
                    'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
                    'title.required' => 'Le titre est requis',
                    'image.image' => 'L\'image doit être une image valide',
                    'image.mimes' => 'L\'image doit être au format jpeg, png, jpg, gif ou svg',
                    'image.max' => 'L\'image ne doit pas dépasser 2Mo',
                ]);
            }else{
                $request->validate([
                    'existing_organizer_id' => 'required|exists:organizers,id',
                ],[
                    'existing_organizer_id.required' => 'L\'organisateur sélectionné est requis',
                ]);
            }

            $user = User::create([
                'name' => $request->name,
                'role' => 'organizer',
                'status' => 'active',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);

            if($request->existing_organizer_id){
                $organizer = Organizer::find($request->existing_organizer_id);
                $organizer->user_id = $user->id;
                $organizer->save();
            }else{
                $imageName = null;
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    Storage::disk('public')->putFileAs('organizers', $image, $imageName);
                    $image->move(public_path('images/organizers'), $imageName);
                }
    
                $organizer = Organizer::create([
                    'user_id' => $user->id,
                    'title' => $request->title,
                    'phone_numbre' => $request->phone_numbre,
                    'description' => $request->description,
                    'image' => $imageName,
                ]);
            }

            Mail::to($user->email)->send(new OrganizerAccountCreated($user, $request->password));

            return redirect()->route('organizers')->with('success', 'Organisateur créé avec succès');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de l\'organisateur: ' . $e->getMessage(), ['exception' => $e]);
            $errorMsg = $e->getMessage();
            return redirect()->back()->withInput()->with('error', $errorMsg);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Organizer $organizer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organizer $organizer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organizer $organizer)
    {
        try{
            $request->validate([
                'title' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],[
                'title.required' => 'Le titre est requis',
                'phone.required' => 'Le numéro de téléphone est requis',
                'description.required' => 'La description est requise',
                'image.image' => 'L\'image doit être une image valide',
                'image.mimes' => 'L\'image doit être au format jpeg, png, jpg, gif ou svg',
                'image.max' => 'L\'image ne doit pas dépasser 2Mo',
            ]);

            $imageName = $organizer->image;
            if ($request->hasFile('image')) {
                if ($organizer->image) {
                    // Delete from public/images/organizers
                    if (file_exists(public_path('images/organizers/' . $organizer->image))) {
                        unlink(public_path('images/organizers/' . $organizer->image));
                    }
                    
                    // Delete from storage/app/public/organizers
                    if (Storage::disk('public')->exists('organizers/' . $organizer->image)) {
                        Storage::disk('public')->delete('organizers/' . $organizer->image);
                    }
                }
                
                // Ensure the directory exists
                if (!file_exists(public_path('images/organizers'))) {
                    mkdir(public_path('images/organizers'), 0755, true);
                }
                
                // Store new image
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('organizers', $image, $imageName);
                $image->move(public_path('images/organizers'), $imageName);
            }

            $organizer->update([
                'title' => $request->title,
                'phone_numbre' => $request->phone,
                'description' => $request->description,
                'image' => $imageName,
            ]);

            // Check if this is a profile update (from profile page)
            if ($request->is('profile*') || $request->header('Referer') && str_contains($request->header('Referer'), 'profile')) {
                return redirect()->route('profile.edit')->with('success', 'Informations de l\'organisateur mises à jour avec succès');
            }

            return redirect()->route('organizers')->with('success', 'Organisateur mis à jour avec succès');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour de l\'organisateur: ' . $e->getMessage(), ['exception' => $e]);
            $errorMsg = $e->getMessage();

            if ($request->is('profile*') || $request->header('Referer') && str_contains($request->header('Referer'), 'profile')) {
                return redirect()->route('profile.edit')->withInput()->with('error', $errorMsg);
            }

            return redirect()->back()->withInput()->with('error', $errorMsg);
        }
    }

    /**
     * Update the status of the specified resource in storage.
     */
    public function updateStatus(Request $request, Organizer $organizer)
    {
        try{
            $organizer->user->status = $request->status;
            $organizer->user->save();
            return redirect()->back()->with('success', 'Statut mis à jour avec succès');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du statut de l\'organisateur: ' . $e->getMessage(), ['exception' => $e]);
            $errorMsg = $e->getMessage();
            return redirect()->back()->withInput()->with('error', $errorMsg);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organizer $organizer)
    {
        // try {
        //     // Delete organizer image from both locations if it exists
        //     if ($organizer->image) {
        //         // Delete from public/images/organizers
        //         if (file_exists(public_path('images/organizers/' . $organizer->image))) {
        //             unlink(public_path('images/organizers/' . $organizer->image));
        //         }
                
        //         // Delete from storage/app/public/organizers
        //         if (Storage::disk('public')->exists('organizers/' . $organizer->image)) {
        //             Storage::disk('public')->delete('organizers/' . $organizer->image);
        //         }
        //     }
            
        //     // Delete the organizer and associated user
        //     $user = $organizer->user;
        //     $organizer->delete();
        //     $user->delete();
            
        //     return redirect()->route('organizers')->with('success', 'Organisateur supprimé avec succès');
        // } catch (\Exception $e) {
        //     Log::error('Erreur lors de la suppression de l\'organisateur: ' . $e->getMessage(), ['exception' => $e]);
        //     return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression de l\'organisateur');
        // }
    }
}
