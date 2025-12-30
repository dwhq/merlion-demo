@php
    $options = $self->getOptions();
    $selectedValues = $self->getValue();
    $name = $self->getName();
    $gridColumns = $self->gridColumns ?? 3;
    $colClass = match($gridColumns) {
        1 => 'col-12',
        2 => 'col-md-6',
        3 => 'col-md-4',
        4 => 'col-md-3',
        6 => 'col-md-2',
        default => 'col-md-4'
    };
@endphp
<x-merlion::form.field
    :id="$self->getId()"
    :label="$self->getLabel()"
    :full="$self->full"
    :label_position="$self->labelPosition"
>
    <div class="row">
        @foreach($options as $key => $label)
            <div class="{{ $colClass }} mb-2">
                <label class="form-check">
                    <input type="checkbox"
                           class="form-check-input"
                           name="{{ $name }}[]"
                           value="{{ $key }}"
                           {{ in_array($key, $selectedValues) ? 'checked' : '' }}
                    >
                    <span class="form-check-label">{{ $label }}</span>
                </label>
            </div>
        @endforeach
    </div>
    @if(empty($options))
        <div class="text-muted">No options available</div>
    @endif
</x-merlion::form.field>
