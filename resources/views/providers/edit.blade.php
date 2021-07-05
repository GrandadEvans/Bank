@extends('layouts.app')

@section('content')

    <form
        action="{{ route('providers.update', [$provider->id]) }}"
        method="POST"
        class="form-horizontal col-md-6 offset-3"
        id="providers__edit"
        name="providers__edit"
    >

        <h1>Edit Retailer/Supplier</h1>
        <h2>{{ $provider->name }}</h2>

        @csrf
        @method('PUT')

        @include('partials._errors')

        @include('partials.form_fields._input_text', [
            'name'        => 'name',
            'placeholder' => 'Company name etc',
            'required'    => true,
            'value'       => $provider->name
        ])

        @include('partials.form_fields._payment_type', [
            'abbreviation'      => $provider->paymentMethod->abbreviation,
            'available_methods' => $paymentMethods,
            'label'             => 'Preferred Payment Method',
            'method'            => $provider->paymentMethod->method,
            'name'              => 'payment_method_id',
            'provider_id'       => $provider->payment_method_id,
            'value'             => $provider->payment_method_id
        ])

        @include('partials.form_fields._input_text', [
            'name'        => 'remarks',
            'placeholder' => 'Anything to add?',
            'value'       => $provider->remarks
        ])

{{--        @include('partials.form_fields._input_url', [--}}
{{--            'name'        => 'logo',--}}
{{--            'label'       => 'Company icon/logo',--}}
{{--            'placeholder' => 'The URI to a logo',--}}
{{--            'value'       => $provider->logo--}}
{{--        ])--}}

        @include('partials.form_fields._textarea', [
            'name'        => 'regular_expressions',
            'label'       => 'Regular expressions',
            'placeholder' => "Use any regular expressions that will identify this provider's transactions eg:\n/^Halifax Mortgage.*$/",
            'value'       => $provider->regular_expressions
        ])

        @include('partials.form_fields._button_submit', [
            'text' => 'Update Provider'
        ])

    </form>
@endsection
