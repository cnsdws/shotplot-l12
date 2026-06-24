<?php

namespace App\Http\Controllers;

use App\Models\Rifle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RifleController extends Controller
{
    public function index()
    {
        $rifles = Rifle::where('user_id', Auth::id())->orderBy('name')->get();
        return view('rifles.index', compact('rifles'));
    }

    public function create()
    {
        return view('rifles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'caliber' => ['nullable', 'string', 'max:255'],
            'sight_type' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'sight_click_moa' => ['required', 'numeric', 'min:0.01', 'max:5'],
            'notes' => ['nullable', 'string'],
        ]);

        $data['user_id'] = Auth::id();

        Rifle::create($data);

        return redirect('/rifles');
    }

    public function edit(Rifle $rifle)
    {
        abort_unless($rifle->user_id === Auth::id(), 403);
        return view('rifles.edit', compact('rifle'));
    }

    public function update(Request $request, Rifle $rifle)
    {
        abort_unless($rifle->user_id === Auth::id(), 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'caliber' => ['nullable', 'string', 'max:255'],
            'sight_type' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255'],
            'sight_click_moa' => ['required', 'numeric', 'min:0.01', 'max:5'],
            'notes' => ['nullable', 'string'],
        ]);

        $rifle->update($data);

        return redirect('/rifles');
    }

    public function destroy(Rifle $rifle)
    {
        abort_unless($rifle->user_id === Auth::id(), 403);
        $rifle->delete();

        return redirect('/rifles');
    }
    public function history(Rifle $rifle)
    {
        $zeros = $rifle->zeros()->orderBy('distance')->get();

        $matches = $rifle->matches()
            ->with('firestrings')
            ->orderBy('date', 'desc')
            ->get();

        return view('rifles.history', compact('rifle', 'zeros', 'matches'));
    }
}
