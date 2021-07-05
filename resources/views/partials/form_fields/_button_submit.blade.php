@php
$name = isset($name) ? $name : 'submit';
$text = isset($text) ? $text : 'Submit';
@endphp

<div class="form-group row">
    <button
        type="submit"
        class="btn btn-primary"
        name="{{ $name }}"
        id="{{ $name }}"
    >{{ $text }}</button>
</div>
