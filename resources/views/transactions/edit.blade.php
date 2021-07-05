@extends('layouts.app')

@section('content')

    <form
        action="{{ route('transactions.update', [$transaction->id]) }}"
        method="POST"
        class="form-horizontal col-md-6 offset-3"
        id="transactions__edit"
        name="transactions__edit"
    >

        <h1>Edit Transaction</h1>
        <h2>"{{ $transaction->entry }}"</h2>

        @csrf
        @method('PUT')

        @include('partials._errors')


        @error('date')
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

        <div class="form-group row @error('date') is-invalid @enderror">
            <label for="date" class="col-sm-3 control-label">Date</label>
            <div class="col-sm-5">
                <input
                    type="text"
                    class="form-control"
                    id="date"
                    name="date"
                    placeholder="eg 25-12-2018"
                    required="required"
                    value="{{ $transaction['date']->format('d-m-Y') }}"
                >
                <small id="nextDueHelpBlock" class="form-text text-muted">
                    The date format should be DD-MM-YYYY eg 31-12-2019
                </small>
            </div>
        </div>

        @include('partials.form_fields._formFieldErrors', [
            'field' => 'entry',
            'errors' => $errors
        ])

        <div class="form-group row @error('entry') is-invalid @enderror">
            <label for="entry" class="col-sm-3 control-label">Entry</label>
            <div class="col-sm-5">
                <input
                    type="text"
                    class="form-control"
                    id="entry"
                    name="entry"
                    placeholder="Enter a description"
                    required="required"
                    value="{{ $transaction['entry'] }}"
                >
            </div>
        </div>

        @include('partials.form_fields._formFieldErrors', [
            'field' => 'amount',
            'errors' => $errors
        ])

        <div class="form-group row @error('amount') is-invalid @enderror">
            <label for="amount" class="col-sm-3 control-label">Amount</label>
            <div class="col-sm-5">
                <input
                    type="text"
                    id="amount"
                    name="amount"
                    class="form-control"
                    placeholder="-12.34"
                    required="required"
                    aria-label="amount"
                    aria-describedby="basic-addon1"
                    value="{{ $transaction['amount'] }}"
                >
            </div>
        </div>

        @include('partials.form_fields._formFieldErrors', [
            'field' => 'balance',
            'errors' => $errors
        ])


        <div class="form-group row @error('balance') is-invalid @enderror">
            <label for="balance" class="col-sm-3 control-label">Balance</label>
            <div class="col-sm-5">
                <input
                    type="text"
                    id="balance"
                    name="balance"
                    class="form-control"
                    placeholder="-12.34"
                    required="required"
                    aria-label="Balance"
                    aria-describedby="basic-addon1"
                    value="{{ $transaction['balance'] }}"
                >
            </div>
        </div>


        @include('partials.form_fields._formFieldErrors', [
            'field' => 'provider_id',
            'errors' => $errors
        ])

        <div class="form-group row">
            <label for="provider_id" class="col-sm-3 control-label">Transaction Provider</label>
            <div class="col-sm-5">
                <select name="provider_id" id="provider_id">
                    @foreach($providers as $indProvider)
                        <option
                            value="{{ $indProvider->id }}"
                            @if ($indProvider->id == $transaction->provider->id) selected="selected" @endif()
                        >{{ $indProvider->name }}</option>
                    @endforeach()
                </select>
            </div>
        </div>

        @include('partials.form_fields._payment_type', [
            'value' => $transaction->payment_method_id,
            'errors' => $errors
        ])

        @include('partials.form_fields._formFieldErrors', [
            'field' => 'remarks',
            'errors' => $errors
        ])

        <div class="form-group row @error('remarks') is-invalid @enderror">
            <label for="remarks" class="col-sm-3 control-label">Remarks</label>
            <div class="col-sm-5">
                <input
                    type="text"
                    id="remarks"
                    name="remarks"
                    class="form-control"
                    placeholder="Anything to add?"
                    value="{{ $transaction['remarks'] }}"
                >
            </div>
        </div>

        <div class="form-group row">
            <button
                type="submit"
                class="btn btn-primary"
                name="submit"
                id="submit"
            >Update Transaction</button>
        </div>

    </form>
@endsection
