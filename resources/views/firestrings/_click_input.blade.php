<div class="form-group">
    <label>{{ $label }}</label>

    <div class="input-group" style="max-width:160px;">
        <span class="input-group-btn">
            <button type="button"
                    class="btn btn-default click-adjust"
                    data-field="{{ $field }}"
                    data-step="-{{ $step ?? 0.25 }}">
                -
            </button>
        </span>

        <input type="text"
               name="{{ $field }}"
               id="{{ $field }}"
               class="form-control text-center"
               value="{{ old($field, $value ?? '') }}">

        <span class="input-group-btn">
            <button type="button"
                    class="btn btn-default click-adjust"
                    data-field="{{ $field }}"
                    data-step="{{ $step ?? 0.25 }}">
                +
            </button>
        </span>
    </div>
</div>
