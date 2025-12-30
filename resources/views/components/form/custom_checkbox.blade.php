<div class="form-group mb-3">
    <label class="form-label">{{ $label }}</label>
    <div class="form-check">
        @foreach($options as $value => $label)
            <div class="form-check">
                <input 
                    class="form-check-input" 
                    type="checkbox" 
                    value="{{ $value }}" 
                    id="{{ $id }}_{{ $value }}"
                    name="{{ $name }}[]"
                    {{ in_array($value, old($name, $value ?? [])) ? 'checked' : '' }}
                >
                <label class="form-check-label" for="{{ $id }}_{{ $value }}">
                    {{ $label }}
                </label>
            </div>
        @endforeach
    </div>
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    @if($description)
        <div class="form-text">{{ $description }}</div>
    @endif
</div>