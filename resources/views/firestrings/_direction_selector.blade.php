<div class="form-group">
    <label>{{ $label }}</label>

    <input type="hidden"
           name="{{ $field }}"
           id="{{ $field }}"
           value="{{ old($field, $value ?? '') }}">

    <div class="btn-group" id="{{ $field }}Buttons">
        @foreach (['9','10','11','12','1','2','3'] as $dir)
            <button type="button"
                    class="btn btn-default"
                    data-value="{{ $dir }} O'clock">
                {{ $dir }}
            </button>
        @endforeach
    </div>
</div>
