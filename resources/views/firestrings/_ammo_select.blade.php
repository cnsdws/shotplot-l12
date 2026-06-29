<div class="form-group">
    <label>Ammo</label>

    <select name="ballistic_profile_id"
            id="ballistic_profile_id"
            class="form-control">
        <option value="">-- None selected --</option>

        <optgroup label="ShotPlot Library">
            @foreach($ballisticProfiles->where('is_system', true) as $profile)
                <option value="{{ $profile->id }}"
                    {{ old('ballistic_profile_id', optional($firestring ?? null)->ballistic_profile_id) == $profile->id ? 'selected' : '' }}>
                    {{ $profile->manufacturer }} - {{ $profile->name }}
                </option>
            @endforeach
        </optgroup>

        <optgroup label="My Profiles">
            @foreach($ballisticProfiles->where('is_system', false) as $profile)
                <option value="{{ $profile->id }}"
                    {{ old('ballistic_profile_id', optional($firestring ?? null)->ballistic_profile_id) == $profile->id ? 'selected' : '' }}>
                    {{ $profile->manufacturer }} - {{ $profile->name }}
                </option>
            @endforeach
        </optgroup>
    </select>
</div>

@if(isset($defaultAmmoMap))
<div class="checkbox">
    <label>
        <input type="checkbox"
               id="useDefaultAmmo"
               checked>
        Auto-select rifle default ammo
    </label>
</div>
@endif

