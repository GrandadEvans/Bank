@extends('layouts.app')

@section('content')
    <form
        action="{{ route('providers.store') }}"
        method="post"
        class="form-horizontal col-md-6 offset-3 @if (!empty($errors->bags)) was-validated @endif"
        id="providers__create"
        name="providers__create"

    >

        <h1>Add a new Services/Product Provider</h1>

        @csrf

        @include('partials.form_fields._input_text', [
            'name' => 'name',
            'placeholder' => 'Company name etc',
            'required' => true
        ])

        @include('partials.form_fields._payment_type', [
            'available_methods' => $paymentMethods,
            'name' => 'payment_method_id',
            'label' => 'Preferred Payment Method'
        ])


        @include('partials.form_fields._input_text', [
            'name' => 'remarks',
            'placeholder' => 'Anything to add?'
        ])

{{--        @include('partials.form_fields._input_url', [--}}
{{--            'name' => 'logo',--}}
{{--            'label' => 'Company icon/logo',--}}
{{--            'placeholder' => 'The URI to a logo'--}}
{{--        ])--}}

        @include('partials.form_fields._textarea', [
            'name' => 'regular_expressions',
            'label' => 'Regular expressions',
            'placeholder' => "Use any regular expressions that will identify this provider's transactions eg:\n/^Halifax Mortgage.*$/"
        ])

        @include('partials.form_fields._button_submit', [
            'text' => 'Add Provider'
        ])

    </form>
@endsection
