<?php

namespace App\Http\Controllers;

use App\Models\BallisticProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BallisticProfileController extends Controller
{
    public function index()
    {
        $profiles = BallisticProfile::where('active', true)
            ->where(function ($query) {
                $query->whereNull('user_id')
                      ->orWhere('user_id', Auth::id());
            })
            ->orderBy('display_order')
            ->orderBy('caliber')
            ->orderBy('bullet_weight')
            ->orderBy('name')
            ->get();

        return view('ballistics.index', compact('profiles'));
    }

    public function create()
    {
        return view('ballistics.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        $data['user_id'] = Auth::id();
        $data['is_system'] = false;

        BallisticProfile::create($data);

        return redirect('/ballistics');
    }

    public function edit(BallisticProfile $ballisticProfile)
    {
        if ($ballisticProfile->is_system || $ballisticProfile->user_id !== Auth::id()) {
            abort(403);
        }

        return view('ballistics.edit', compact('ballisticProfile'));
    }

    public function update(Request $request, BallisticProfile $ballisticProfile)
    {
        if ($ballisticProfile->is_system || $ballisticProfile->user_id !== Auth::id()) {
            abort(403);
        }

        $ballisticProfile->update($this->validatedData($request));

        return redirect('/ballistics');
    }

    public function destroy(BallisticProfile $ballisticProfile)
    {
        if ($ballisticProfile->is_system || $ballisticProfile->user_id !== Auth::id()) {
            abort(403);
        }

        $ballisticProfile->update([
            'active' => false,
        ]);

        return redirect('/ballistics');
    }

    private function validatedData(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',

            'manufacturer' => 'nullable|string|max:255',
            'manufacturer_product_number' => 'nullable|string|max:255',
            'upc' => 'nullable|string|max:255',

            'cartridge' => 'nullable|string|max:255',
            'caliber' => 'nullable|string|max:255',

            'bullet_manufacturer' => 'nullable|string|max:255',
            'bullet_name' => 'nullable|string|max:255',
            'bullet_weight' => 'nullable|integer',
            'bullet_style' => 'nullable|string|max:255',

            'muzzle_velocity' => 'nullable|integer',
            'muzzle_energy' => 'nullable|integer',

            'g1_bc' => 'nullable|numeric',
            'g7_bc' => 'nullable|numeric',
            'sectional_density' => 'nullable|numeric',

            'test_barrel_length' => 'nullable|numeric',

            'case_type' => 'nullable|string|max:255',
            'primer_type' => 'nullable|string|max:255',

            'reloadable' => 'nullable|boolean',
            'lead_free' => 'nullable|boolean',
            'corrosive' => 'nullable|boolean',

            'powder' => 'nullable|string|max:255',
            'powder_charge' => 'nullable|numeric',
            'primer' => 'nullable|string|max:255',
            'brass' => 'nullable|string|max:255',
            'overall_length' => 'nullable|numeric',

            'lot_number' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',

            'best_use' => 'nullable|string|max:255',
            'country_of_origin' => 'nullable|string|max:255',

            'notes' => 'nullable|string',
        ]);
    }
}
