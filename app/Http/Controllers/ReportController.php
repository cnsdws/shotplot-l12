<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Firestring;

class ReportController extends Controller
{
    public function printFirestring($id)
    {
        $firestring = Firestring::with([
            'match.rifle',
            'adjustments' => function ($query) {
                $query->orderBy('shot_number');
            },
        ])->findOrFail($id);

        return view('printfirestring', compact('firestring'));
    }
}
