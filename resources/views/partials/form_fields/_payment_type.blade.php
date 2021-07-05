@php
    $method = $method ?? 'Payment Method';
    $label = (empty($label)) ?: 'Payment Method';

    if (null !== old('payment_method_id') && ! empty(old('payment_method_id'))) {
        $value = old('payment_method_id');
    } elseif (isset($value) && ! empty($value)) {
        $value = $value; // just here for content in the braces
    } else {
        $value = '';
    }
@endphp

@include('partials.form_fields._formFieldErrors', [
    'field'   => 'payment_method_id',
    'errors' => $errors
])

<div class="form-group row">
    <label for="payment_method_id" class="col-sm-3 control-label">{{ $label }}</label>
    <div class="col-sm-5">
        <select name="payment_method_id" id="payment_method_id">
            @foreach($paymentMethods as $option)
                <option
                    value="{{ $option->id }}"
                    data-abbreviation="{{ $option->abbreviation }}"
                    @if(old('payment_method_id') == $option->id) selected aria-selected
                    @elseif($value == $option->id) selected aria-selected
                    @endif()
                >{{ $option->method }}</option>
            @endforeach
        </select>
    </div>
</div>
