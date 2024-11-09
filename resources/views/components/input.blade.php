@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'autofocus' => false,
    'autocomplete' => 'off',
    'additionalClasses' => '',
])

<div class="{{ $additionalClasses }}">
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}" @if ($required) required @endif
        @if ($autofocus) autofocus @endif
        class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}" autocomplete="{{ $autocomplete }}">

    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
