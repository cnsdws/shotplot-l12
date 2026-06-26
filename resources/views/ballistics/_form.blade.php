@php
    $profile = $ballisticProfile ?? null;
@endphp

<div class="panel panel-default">
    <div class="panel-heading">
        <a data-toggle="collapse" href="#generalPanel">
            <strong>General</strong>
        </a>
    </div>

    <div id="generalPanel" class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="form-group">
                <label>Name</label>
                <input class="form-control" type="text" name="name"
                       value="{{ old('name', optional($profile)->name) }}">
            </div>

            <div class="form-group">
                <label>Type</label><br>

                <label class="radio-inline">
                    <input type="radio" name="type" value="Factory"
                        {{ old('type', optional($profile)->type ?? 'Factory') == 'Factory' ? 'checked' : '' }}>
                    Factory Ammunition
                </label>

                <label class="radio-inline">
                    <input type="radio" name="type" value="Handload"
                        {{ old('type', optional($profile)->type) == 'Handload' ? 'checked' : '' }}>
                    Handload
                </label>
            </div>

            <div class="form-group">
                <label>Manufacturer</label>
                <input class="form-control" type="text" name="manufacturer"
                       value="{{ old('manufacturer', optional($profile)->manufacturer) }}">
            </div>

            <div class="form-group">
                <label>Cartridge</label>
                <input class="form-control" type="text" name="cartridge"
                       value="{{ old('cartridge', optional($profile)->cartridge) }}">
            </div>

            <div class="form-group">
                <label>Caliber</label>
                <input class="form-control" type="text" name="caliber"
                       value="{{ old('caliber', optional($profile)->caliber) }}">
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <a data-toggle="collapse" href="#bulletPanel">
            <strong>Bullet</strong>
        </a>
    </div>

    <div id="bulletPanel" class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="form-group">
                <label>Bullet Manufacturer</label>
                <input class="form-control" type="text" name="bullet_manufacturer"
                       value="{{ old('bullet_manufacturer', optional($profile)->bullet_manufacturer) }}">
            </div>

            <div class="form-group">
                <label>Bullet Name</label>
                <input class="form-control" type="text" name="bullet_name"
                       value="{{ old('bullet_name', optional($profile)->bullet_name) }}">
            </div>

            <div class="form-group">
                <label>Bullet Weight</label>
                <input class="form-control" type="number" name="bullet_weight"
                       value="{{ old('bullet_weight', optional($profile)->bullet_weight) }}">
            </div>

            <div class="form-group">
                <label>Bullet Style</label>
                <input class="form-control" type="text" name="bullet_style"
                       value="{{ old('bullet_style', optional($profile)->bullet_style) }}">
            </div>

            <div class="form-group">
                <label>G1 Ballistic Coefficient</label>
                <input class="form-control" type="text" name="g1_bc"
                       value="{{ old('g1_bc', optional($profile)->g1_bc) }}">
            </div>

            <div class="form-group">
                <label>G7 Ballistic Coefficient</label>
                <input class="form-control" type="text" name="g7_bc"
                       value="{{ old('g7_bc', optional($profile)->g7_bc) }}">
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <a data-toggle="collapse" href="#performancePanel">
            <strong>Performance</strong>
        </a>
    </div>

    <div id="performancePanel" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="form-group">
                <label>Muzzle Velocity</label>
                <input class="form-control" type="number" name="muzzle_velocity"
                       value="{{ old('muzzle_velocity', optional($profile)->muzzle_velocity) }}">
            </div>

            <div class="form-group">
                <label>Muzzle Energy</label>
                <input class="form-control" type="number" name="muzzle_energy"
                       value="{{ old('muzzle_energy', optional($profile)->muzzle_energy) }}">
            </div>

            <div class="form-group">
                <label>Sectional Density</label>
                <input class="form-control" type="text" name="sectional_density"
                       value="{{ old('sectional_density', optional($profile)->sectional_density) }}">
            </div>

            <div class="form-group">
                <label>Test Barrel Length</label>
                <input class="form-control" type="text" name="test_barrel_length"
                       value="{{ old('test_barrel_length', optional($profile)->test_barrel_length) }}">
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default factory-section">
    <div class="panel-heading">
        <a data-toggle="collapse" href="#factoryPanel">
            <strong>Factory Information</strong>
        </a>
    </div>

    <div id="factoryPanel" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="form-group">
                <label>Product Number</label>
                <input class="form-control" type="text" name="manufacturer_product_number"
                       value="{{ old('manufacturer_product_number', optional($profile)->manufacturer_product_number) }}">
            </div>

            <div class="form-group">
                <label>UPC</label>
                <input class="form-control" type="text" name="upc"
                       value="{{ old('upc', optional($profile)->upc) }}">
            </div>

            <div class="form-group">
                <label>Case Type</label>
                <input class="form-control" type="text" name="case_type"
                       value="{{ old('case_type', optional($profile)->case_type) }}">
            </div>

            <div class="form-group">
                <label>Primer Type</label>
                <input class="form-control" type="text" name="primer_type"
                       value="{{ old('primer_type', optional($profile)->primer_type) }}">
            </div>

            <div class="form-group">
                <label>Best Use</label>
                <input class="form-control" type="text" name="best_use"
                       value="{{ old('best_use', optional($profile)->best_use) }}">
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="reloadable" value="1"
                        {{ old('reloadable', optional($profile)->reloadable) ? 'checked' : '' }}>
                    Reloadable
                </label>
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="lead_free" value="1"
                        {{ old('lead_free', optional($profile)->lead_free) ? 'checked' : '' }}>
                    Lead Free
                </label>
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="corrosive" value="1"
                        {{ old('corrosive', optional($profile)->corrosive) ? 'checked' : '' }}>
                    Corrosive
                </label>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default handload-section">
    <div class="panel-heading">
        <a data-toggle="collapse" href="#handloadPanel">
            <strong>Handload Information</strong>
        </a>
    </div>

    <div id="handloadPanel" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="form-group">
                <label>Powder</label>
                <input class="form-control" type="text" name="powder"
                       value="{{ old('powder', optional($profile)->powder) }}">
            </div>

            <div class="form-group">
                <label>Powder Charge</label>
                <input class="form-control" type="text" name="powder_charge"
                       value="{{ old('powder_charge', optional($profile)->powder_charge) }}">
            </div>

            <div class="form-group">
                <label>Primer</label>
                <input class="form-control" type="text" name="primer"
                       value="{{ old('primer', optional($profile)->primer) }}">
            </div>

            <div class="form-group">
                <label>Brass</label>
                <input class="form-control" type="text" name="brass"
                       value="{{ old('brass', optional($profile)->brass) }}">
            </div>

            <div class="form-group">
                <label>Overall Length</label>
                <input class="form-control" type="text" name="overall_length"
                       value="{{ old('overall_length', optional($profile)->overall_length) }}">
            </div>

            <div class="form-group">
                <label>Lot Number</label>
                <input class="form-control" type="text" name="lot_number"
                       value="{{ old('lot_number', optional($profile)->lot_number) }}">
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <a data-toggle="collapse" href="#notesPanel">
            <strong>Notes</strong>
        </a>
    </div>

    <div id="notesPanel" class="panel-collapse collapse in">
        <div class="panel-body">
            <textarea class="form-control" name="notes" rows="4">{{ old('notes', optional($profile)->notes) }}</textarea>
        </div>
    </div>
</div>

<script>
(function () {
    function updateSections() {
        const selected = document.querySelector('input[name="type"]:checked');
        const type = selected ? selected.value : 'Factory';

        document.querySelectorAll('.factory-section').forEach(function (el) {
            el.style.display = type === 'Factory' ? '' : 'none';
        });

        document.querySelectorAll('.handload-section').forEach(function (el) {
            el.style.display = type === 'Handload' ? '' : 'none';
        });
    }

    document.querySelectorAll('input[name="type"]').forEach(function (radio) {
        radio.addEventListener('change', updateSections);
    });

    updateSections();
})();
</script>
