@include('partials.form_fields._input_text', [
    'type' => 'url',
    'value' => (isset($value)) ? $value : ''
])
