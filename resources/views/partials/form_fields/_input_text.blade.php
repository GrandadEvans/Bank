@php
    if (null !== old($name) && ! empty(old($name))) {
        $value = old($name);
    } elseif (isset($value) && ! empty($value)) {
        $value = $value; // just here for content in the braces
    } else {
        $value = '';
    }
    $placeholder = isset($placeholder) ? $placeholder : 'test';
    $label = isset($label) ? $label : ucwords($name);
    $type = isset($type) ? $type : 'text';
    $help_text = isset($help_text) ? $help_text : null;
@endphp

@error($name)
<div class="alert alert-danger col-sm-12">
    <div class="alert alert-danger col-sm-12">
        @if (is_iterable($message))
            <ul>
                @foreach($message as $indMessage)
                    <li>{{ $indMessage }}</li>
                @endforeach
            </ul>
        @else
            {{ $message }}
        @endif
    </div>
</div>
@enderror

<div class="form-group row @error($name) is-invalid @enderror @if (!empty($errors) && null === $errors->$name) is-valid @endif">
    <label for="{{ $name }}" class="col-sm-3 control-label">{{ $label }}</label>
    <div class="col-sm-5">
        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            class="form-control"
            placeholder="{{ $placeholder }}"
            value="{{ $value }}"
            @if (isset($required)) required="required" aria-required="true" @endif
            @if (isset($help_text)) aria-describedby="help_text_for_{{ $name }}" @endif
        >
    </div>
    @if (null !== $help_text)
        <small id="help_text_for_{{ $name }}" class="form-text text-muted">
            {{ $help_text }}
        </small>
    @endif()
</div>
