<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('parametres.application.application');
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:1024',
            'slider-image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5072',
        ]);

        $config = config('application');
        $logoPath = $config['logo'];
        $faviconPath = $config['favicon'];
        $sliderImagePath = $config['slider-image'];

        if ($request->hasFile('slider-image')) {
            if ($sliderImagePath && file_exists(public_path($sliderImagePath))) {
                @unlink(public_path($sliderImagePath));
            }
            $sliderImage = $request->file('slider-image');
            $sliderImageName = 'slider-image_' . time() . '.' . $sliderImage->getClientOriginalExtension();
            $sliderImage->move(public_path('images/applications'), $sliderImageName);
            $sliderImagePath = 'images/applications/' . $sliderImageName;
        }
        if ($request->hasFile('logo')) {
            if ($logoPath && file_exists(public_path($logoPath))) {
                @unlink(public_path($logoPath));
            }
            $logo = $request->file('logo');
            $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/applications'), $logoName);
            $logoPath = 'images/applications/' . $logoName;
        }
        if ($request->hasFile('favicon')) {
            if ($faviconPath && file_exists(public_path($faviconPath))) {
                @unlink(public_path($faviconPath));
            }
            $favicon = $request->file('favicon');
            $faviconName = 'favicon_' . time() . '.' . $favicon->getClientOriginalExtension();
            $favicon->move(public_path('images/applications'), $faviconName);
            $faviconPath = 'images/applications/' . $faviconName;
        }

        $newConfig = [
            'name' => $request->name,
            'slogan' => $request->slogan,
            'logo' => $logoPath,
            'favicon' => $faviconPath,
            'slider-image' => $sliderImagePath,
        ];

        $configContent = "<?php\n\nreturn [\n";
        foreach ($newConfig as $key => $value) {
            $configContent .= "    '" . $key . "' => '" . addslashes($value) . "',\n";
        }
        $configContent .= "];\n";
        File::put(config_path('application.php'), $configContent);

        return redirect()->back()->with('success', 'Paramètres de l\'application mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
