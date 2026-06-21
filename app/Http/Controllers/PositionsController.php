<?php

namespace App\Http\Controllers;

use App\Models\Firestring;
use App\Models\ShootingMatch;
use App\Models\User;
use App\Models\Rifle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PositionsController extends Controller
{
    public function index()
    {
        $matches = ShootingMatch::where('user_id', Auth::id())->get();
        return view('index', compact('matches'));
    }

    public function create()
    {
        $rifles = Rifle::where('user_id', Auth::id())->orderBy('name')->get();
        return view('create', compact('rifles'));
    }

    public function handleCreate(Request $request)
    {
        $data = $request->validate([
            'place' => 'required',
            'date' => 'required',
            'rifle_id' => 'nullable|exists:rifles,id',
            'riflenumber' => 'nullable',
            'rangename' => 'nullable',
        ]);

        $data['riflenumber'] = '';
        $data['user_id'] = Auth::id();

        ShootingMatch::create($data);

        return redirect()->action([self::class, 'index']);
    }

    public function edit(ShootingMatch $match)
    {
        $rifles = Rifle::where('user_id', Auth::id())->orderBy('name')->get();
        return view('edit', compact('match', 'rifles'));
    }

    public function handleEdit(Request $request)
    {
        $match = ShootingMatch::findOrFail($request->input('id'));

        $match->update([
            'place' => $request->input('place'),
            'date' => $request->input('date'),
            'rifle_id' => $request->input('rifle_id'),
            'riflenumber' => $request->input('riflenumber'),
            'rangename' => $request->input('rangename'),
            'user_id' => Auth::id(),
        ]);

        return redirect()->action([self::class, 'index']);
    }

    public function delete(ShootingMatch $match)
    {
        return view('delete', compact('match'));
    }

    public function handleDelete(Request $request)
    {
        $match = ShootingMatch::findOrFail($request->input('match'));

        $match->firestrings()->delete();
        $match->delete();

        return redirect()->action([self::class, 'index']);
    }

    public function myaccount()
    {
        $id = Auth::id();
        return view('myaccount', compact('id'));
    }

    public function handleMyAccount(Request $request)
    {
        $user = Auth::user();

        $user->email = $request->input('email');
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->save();

        return redirect()->action([self::class, 'index']);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required|min:6',
            'confirmpassword' => 'required|same:newpassword',
        ]);

        $user = User::findOrFail(Auth::id());

        if (! Hash::check($request->input('oldpassword'), $user->password)) {
            return redirect('/myaccount')
                ->with('flash_message', '<br><p class="bg-danger">Your password could not be changed!</p>');
        }

        $user->password = Hash::make($request->input('newpassword'));
        $user->save();

        return redirect('/myaccount')
            ->with('flash_message', '<br><p class="bg-success">Your password has been changed!</p>');
    }

    public function editFirestring($id)
    {
        $firestring = Firestring::findOrFail($id);
        return view('editfirestring', compact('firestring'));
    }

    public function handleEditFirestring(Request $request, $id)
    {
        $firestring = Firestring::findOrFail($request->input('id'));
        $match_id = $firestring->match_id;

        $firestring->update($request->only([
            'fire_string_number',
            'distance',
            'target',
            'relay',
            'lightdirection',
            'winddirection',
            'windspeed',
            'elevation',
            'windage',
            'shot1value',
            'shot2value',
            'shot3value',
            'shot4value',
            'shot5value',
            'shot6value',
            'shot7value',
            'shot8value',
            'shot9value',
            'shot10value',
            'shot1x',
            'shot1y',
	    'shot2x',
	    'shot2y',
	    'shot3x',
	    'shot3y',
	    'shot4x',
	    'shot4y',
	    'shot5x',
	    'shot5y',
	    'shot6x',
	    'shot6y',
	    'shot7x',
	    'shot7y',
	    'shot8x',
 	    'shot8y',
	    'shot9x',
	    'shot9y',
	    'shot10x',
	    'shot10y',
        ]));

        return redirect('indexfirestring/'.$match_id);
    }

    public function deleteFirestring($id)
    {
        $firestring = Firestring::findOrFail($id);
        return view('deletefirestring', compact('firestring'));
    }

    public function handleDeleteFirestring($id)
    {
        $firestring = Firestring::findOrFail($id);
        $match_id = $firestring->match_id;
        $firestring->delete();

        return redirect('indexfirestring/'.$match_id);
    }

    public function indexFirestring($id)
    {
        $match = ShootingMatch::findOrFail($id);
        $firestrings = Firestring::where('match_id', $match->id)->get();

        return view('indexfirestring', compact('match', 'firestrings'));
    }

    public function createFirestring($match_id)
    {
        return view('createfirestring', compact('match_id'));
    }

    public function handleCreateFirestring(Request $request)
    {
        $request->validate([
            'fire_string_number' => 'required',
            'distance' => 'required',
            'match_id' => 'required|exists:matches,id',
        ]);

        $match = ShootingMatch::findOrFail($request->input('match_id'));

        $firestring = new Firestring($request->only([
            'fire_string_number',
            'distance',
            'target',
            'relay',
            'lightdirection',
            'winddirection',
            'windspeed',
            'elevation',
            'windage',
            'shot1value',
            'shot2value',
            'shot3value',
            'shot4value',
            'shot5value',
            'shot6value',
            'shot7value',
            'shot8value',
            'shot9value',
            'shot10value',
        ]));

        $firestring->match()->associate($match);
        $firestring->save();

        return redirect('/indexfirestring/'.$match->id);
    }

    public function displayFirestring($id)
    {
        $firestring = Firestring::findOrFail($id);
        return view('displayfirestring', compact('firestring'));
    }
}
