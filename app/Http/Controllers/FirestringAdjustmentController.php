<?php

namespace App\Http\Controllers;

use App\Models\Firestring;
use App\Models\FirestringAdjustment;
use Illuminate\Http\Request;

class FirestringAdjustmentController extends Controller
{
    public function index(Firestring $firestring)
    {
        $adjustments = $firestring->adjustments()
            ->orderBy('shot_number')
            ->get();

        return view('firestringadjustments.index', compact('firestring', 'adjustments'));
    }

    public function create(Firestring $firestring)
    {
        return view('firestringadjustments.create', compact('firestring'));
    }

    public function store(Request $request, Firestring $firestring)
    {
        $data = $request->validate([
            'shot_number' => 'required|integer|min:1|max:20',
            'elevation_setting' => 'nullable|integer',
            'windage_setting' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        $data['firestring_id'] = $firestring->id;

        FirestringAdjustment::create($data);

        return redirect("/firestrings/{$firestring->id}/adjustments");
    }

    public function edit(FirestringAdjustment $adjustment)
    {
        return view('firestringadjustments.edit', compact('adjustment'));
    }

    public function update(Request $request, FirestringAdjustment $adjustment)
    {
        $data = $request->validate([
            'shot_number' => 'required|integer|min:1|max:20',
            'elevation_setting' => 'nullable|integer',
            'windage_setting' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        $adjustment->update($data);

        return redirect("/firestrings/{$adjustment->firestring_id}/adjustments");
    }

    public function destroy(FirestringAdjustment $adjustment)
    {
        $firestringId = $adjustment->firestring_id;

        $adjustment->delete();

        return redirect("/firestrings/{$firestringId}/adjustments");
    }
}
