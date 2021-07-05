@php
    if (null !== old($name) && ! empty(old($name))) {
        $value = old($name);
    } elseif (isset($value) && ! empty($value)) {
        $value = $value; // just here for content in the braces
    } else {
        $value = '';
    }
    $label = isset($label) ? $label : ucwords($name);
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

<div class="form-group row">
    <label for="{{ $name }}" class="col-sm-3 control-label">{{ $label }}</label>
    <div class="col-sm-5">
        <input
            type="checkbox"
            id="{{ $name }}"
            name="{{ $name }}"
            class="form-check"
            value="1"
        >
    </div>
</div>
