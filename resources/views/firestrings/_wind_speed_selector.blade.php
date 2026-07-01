<div class="form-group">
    <label>Wind Speed (mph)</label>

    <input type="hidden"
           name="windspeed"
           id="windspeed"
           value="{{ old('windspeed', $value ?? '') }}">

    <div class="btn-group" id="windspeedButtons">
        @foreach ([0,5,10,15,20,25] as $speed)
            <button type="button"
                    class="btn btn-default"
                    data-value="{{ $speed }}">
                {{ $speed }}
            </button>
        @endforeach
    </div>
</div>
