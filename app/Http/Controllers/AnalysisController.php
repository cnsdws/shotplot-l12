<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShootingMatch;

class AnalysisController extends Controller
{
    public function matchSummary(ShootingMatch $match)
    {
        $match->load([
            'rifle',
            'firestrings' => function ($query) {
                $query->with('ballisticProfile')
                    ->orderBy('fire_string_number');
            },
        ]);

        return view('matchsummary', compact('match'));
    }
}
