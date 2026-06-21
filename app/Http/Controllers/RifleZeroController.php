<?php

namespace App\Http\Controllers;

use App\Models\Rifle;
use App\Models\RifleZero;
use Illuminate\Http\Request;

class RifleZeroController extends Controller
{
    public function index(Rifle $rifle)
    {
        $zeros = $rifle->zeros()->orderBy('distance')->get();

        return view('riflezeros.index', compact('rifle', 'zeros'));
    }

    public function create(Rifle $rifle)
    {
        return view('riflezeros.create', compact('rifle'));
    }

    public function store(Request $request, Rifle $rifle)
    {
        $data = $request->validate([
            'distance' => 'required',
            'elevation' => 'nullable|integer',
            'windage' => 'nullable|integer',
            'notes' => 'nullable',
        ]);

        $data['rifle_id'] = $rifle->id;

        RifleZero::create($data);

        return redirect("/rifles/{$rifle->id}/zeros");
    }

    public function edit(RifleZero $zero)
    {
        return view('riflezeros.edit', compact('zero'));
    }

    public function update(Request $request, RifleZero $zero)
    {
        $data = $request->validate([
            'distance' => 'required',
            'elevation' => 'nullable|integer',
            'windage' => 'nullable|integer',
            'notes' => 'nullable',
        ]);

        $zero->update($data);

        return redirect("/rifles/{$zero->rifle_id}/zeros");
    }

    public function destroy(RifleZero $zero)
    {
        $rifleId = $zero->rifle_id;

        $zero->delete();

        return redirect("/rifles/{$rifleId}/zeros");
    }
}
