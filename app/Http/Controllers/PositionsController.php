<?php

namespace App\Http\Controllers;

use App\Models\Firestring;
use App\Models\ShootingMatch;
use App\Models\User;
use App\Models\Rifle;
use App\Models\BallisticProfile;

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
        $firestring = Firestring::with('match.rifle')->findOrFail($id);

        $ballisticProfiles = $this->compatibleAmmoQuery(optional($firestring->match)->rifle)->get();

        return view('editfirestring', compact('firestring', 'ballisticProfiles'));
    }

    public function handleEditFirestring(Request $request, $id)
    {
        $firestring = Firestring::findOrFail($request->input('id'));
        $match_id = $firestring->match_id;
        $request->merge([
            'windspeed' => $request->input('windspeed') ?? 0,
        ]);

        $fields = [
            'fire_string_number',
            'distance',
            'ballistic_profile_id',
            'target',
            'relay',
            'lightdirection',
            'winddirection',
            'windspeed',
            'temperature',
            'sky_condition',
            'range_notes',
            'elevation',
            'windage',
        ];

        for ($i = 1; $i <= 20; $i++) {
            $fields[] = "shot{$i}value";
            $fields[] = "shot{$i}x";
            $fields[] = "shot{$i}y";
        }

        $firestring->update($request->only($fields));

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

        $firestrings = $match->firestrings()
            ->with('ballisticProfile')
            ->get();

        return view('indexfirestring', compact('match', 'firestrings'));
    }

    public function createFirestring($match_id)
    {
        $match = ShootingMatch::with('rifle.zeros')->findOrFail($match_id);

        $zeros = $match->rifle
            ? $match->rifle->zeros->keyBy('distance')
            : collect();
        
        $ballisticProfiles = $this->compatibleAmmoQuery($match->rifle)->get();
        
        $defaultAmmoMap = $match->rifle
            ? $match->rifle
                ->defaultAmmos()
                ->pluck('ballistic_profile_id', 'distance')
            : collect();

        return view('createfirestring', compact(
            'match_id',
            'match',
            'zeros',
            'ballisticProfiles',
            'defaultAmmoMap'
        ));
    }

    public function handleCreateFirestring(Request $request)
    {
        $request->validate([
            'fire_string_number' => 'required',
            'distance' => 'required',
            'match_id' => 'required|exists:matches,id',
        ]);

        $match = ShootingMatch::findOrFail($request->input('match_id'));
        $request->merge([
            'windspeed' => $request->input('windspeed') ?? 0,
        ]);

        $fields = [
            'fire_string_number',
            'distance',
            'ballistic_profile_id',
            'target',
            'relay',
            'lightdirection',
            'winddirection',
            'windspeed',
            'temperature',
            'sky_condition',
            'range_notes',
            'elevation',
            'windage',
        ];

        for ($i = 1; $i <= 20; $i++) {
            $fields[] = "shot{$i}value";
            $fields[] = "shot{$i}x";
            $fields[] = "shot{$i}y";
        }

        $firestring = new Firestring($request->only($fields));

        $firestring->match()->associate($match);
        $firestring->save();

        return redirect('/indexfirestring/'.$match->id);
    }

    public function displayFirestring($id)
    {
        $firestring = Firestring::with([
            'match.rifle',
            'ballisticProfile',
            'adjustments' => function ($query) {
                $query->orderBy('shot_number');
            },
        ])->findOrFail($id);
        
        $previousFirestring = Firestring::where('match_id', $firestring->match_id)
            ->where('fire_string_number', '<', $firestring->fire_string_number)
            ->orderByDesc('fire_string_number')
            ->first();

        $nextFirestring = Firestring::where('match_id', $firestring->match_id)
            ->where('fire_string_number', '>', $firestring->fire_string_number)
            ->orderBy('fire_string_number')
            ->first();

        return view('displayfirestring', compact(
            'firestring',
            'previousFirestring',
            'nextFirestring'
        ));
    }

    private function compatibleAmmoQuery($rifle)
    {
        return BallisticProfile::where('active', true)
            ->where(function ($query) {
                $query->whereNull('user_id')
                      ->orWhere('user_id', auth()->id());
            })
            ->when($rifle && in_array($rifle->caliber, ['.223', '5.56', '.223/5.56']), function ($query) {
                $query->whereIn('caliber', ['.223', '5.56', '.223/5.56']);
            })
            ->when($rifle && ! in_array($rifle->caliber, ['.223', '5.56', '.223/5.56']), function ($query) use ($rifle) {
                $query->where('caliber', $rifle->caliber);
            })
            ->orderBy('display_order')
            ->orderBy('name');
    }
    
}
