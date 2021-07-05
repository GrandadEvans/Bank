@extends('layouts.app')

@section('content')

    <form
        action="{{ route('transactions.store') }}"
        method="post"
        class="form-horizontal col-md-6 offset-3"
        id="transactions__create"
        name="transactions__create"
    >

        <h1>Add a new manual trasaction</h1>

        @csrf

        @include('partials.form_fields._input_text', [
            'name' => 'date',
            'required' => true,
            'placeholder' => '25-12-2018',
            'label' => 'Transaction Date',
            'help_text' => 'The date format should be DD-MM-YYYY eg 31-12-2019'
        ])

        @include('partials.form_fields._input_text', [
            'name' => 'entry',
            'label' => 'Entry Text',
            'required' => true,
            'placeholder' => 'PAYPAL 156FHHD'
        ])

        @include('partials.form_fields._input_text', [
            'name' => 'amount',
            'placeholder' => '-12.34',
            'required' => true
        ])

        @include('partials.form_fields._input_text', [
            'name' => 'balance',
            'placeholder' => '-12.34',
            'required' => true
        ])

        @include('partials.form_fields._input_text', [
            'name' => 'remarks',
            'placeholder' => 'Anything to add?'
        ])

        <div class="form-group row">
            <label for="type" class="col-sm-3 control-label">Transaction Provider</label>
            <div class="col-sm-5">
                <select name="provider_id" id="provider_id">
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                    @endforeach()
                </select>
            </div>
        </div>

{{--        @include('partials.form_fields._payment_type', ['value' => $provider->type, 'label' => 'Transaction Type'])--}}

        <div class="form-group row">
            <button
                type="submit"
                class="btn btn-primary"
                name="submit"
                id="submit"
            >Add Transaction</button>
        </div>

    </form>
@endsection
