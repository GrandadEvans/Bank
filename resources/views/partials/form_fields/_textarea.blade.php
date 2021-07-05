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
    $rows = isset($rows) ? $rows : '5';
    $help_text = isset($help_text) ? $help_text : null;
@endphp

@error($name)
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
@enderror

<div class="form-group row @error($name) is-invalid @enderror">
    <label for="{{ $name }}" class="col-sm-3 control-label">{{ $label }}</label>
    <div class="col-sm-5">
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            class="form-control"
            placeholder="{{ $placeholder }}"
            rows="{{ $rows }}"
            @if (isset($required)) required="required" aria-required="true" @endif
        >{{ $value }}</textarea>
    </div>
    @if (isset($help_text))
        <small class="form-text text-muted">
            {{ $help_text }}
        </small>
    @endif()
</div>
