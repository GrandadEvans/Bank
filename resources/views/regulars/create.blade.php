@extends('layouts.app')

@section('content')

    <form
        action="{{ route('regulars.store') }}"
        method="post"
        class="form-horizontal col-md-6 offset-3"
        id="regulars__create"
        name="regulars__create"
    >

        <h1>Add a new regular payment</h1>

        @csrf

        @include('partials.form_fields._input_text', [
            'name' => 'nextDue',
            'label' => 'Next Due Date',
            'required' => true,
            'placeholder' => 'When should the payments start?'
        ])

        @include('partials.form_fields._input_text', [
            'name' => 'description',
            'placeholder' => 'A Company name?',
            'required' => true
        ])

        @include('partials.form_fields._input_text', [
            'name' => 'amount',
            'placeholder' => '-12.34',
            'required' => true
        ])

        @include('partials.form_fields._input_checkbox', [
            'name' => 'estimated'
        ])

        @include('partials.form_fields._input_text', [
            'name' => 'remarks',
            'placeholder' => 'Anything to Add?'
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

        @include('partials.form_fields._payment_type', ['value' => $provider->type])

        <div class="form-group row">
            <label for="days" class="col-sm-3 control-label">Transaction Type</label>
            <div class="col-sm-5">
                <select name="days" id="days">
                    <option value="1w" @if(old('type') == '1w') selected @endif>Weekly</option>
                    <option value="2w" @if(old('type') == '2w') selected @endif>Fortnightly</option>
                    <option value="4w" @if(old('type') == '4w') selected @endif>Four Weekly</option>
                    <option value="1m" @if(old('type') == '1m') selected @endif>Monthly</option>
                    <option value="3m" @if(old('type') == '3m') selected @endif>Quarterly</option>
                    <option value="6m" @if(old('type') == '6m') selected @endif>Six Monthly</option>
                    <option value="1y" @if(old('type') == '1y') selected @endif>Annually</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <button
                type="submit"
                class="btn btn-primary custom-button"
                name="submit"
                id="submit"
            >Add Transaction</button>
        </div>

    </form>
@endsection
