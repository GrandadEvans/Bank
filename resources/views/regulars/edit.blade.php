@extends('layouts.app')

@section('content')

    <form
        action="{{ route('regulars.update', [$regular->id]) }}"
        method="POST"
        class="form-horizontal col-md-6 offset-3"
        id="regulars__edit"
        name="regulars__edit"
    >

        <h1>Edit Regular Transaction</h1>
        <h2>"{{ $regular->description }}"</h2>

        @csrf
        @method('PUT')

        @error('nextDue')
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

        <div class="form-group row @error('nextDue') is-invalid @enderror">
            <label for="nextDue" class="col-sm-3 control-label">Next Due Date</label>
            <div class="col-sm-5">
                <input
                    type="text"
                    class="form-control"
                    id="nextDue"
                    name="nextDue"
                    placeholder="When should the regular transactions start"
                    required="required"
                    value="{{ $regular['nextDue']->format('d-m-Y') }}"
                >
                <small id="nextDueHelpBlock" class="form-text text-muted">
                    The date format should be DD-MM-YYYY eg 31-12-2019
                </small>
            </div>
        </div>

        @error('description')
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

        <div class="form-group row @error('description') is-invalid @enderror">
            <label for="description" class="col-sm-3 control-label">Description</label>
            <div class="col-sm-5">
                <input
                    type="text"
                    class="form-control"
                    id="description"
                    name="description"
                    placeholder="Enter a description or a company name"
                    required="required"
                    value="{{ $regular['description'] }}"
                >
            </div>
        </div>

        @error('amount')
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

        <div class="form-group row @error('amount') is-invalid @enderror">
            <label for="amount" class="col-sm-3 control-label">Amount</label>
            <div class="col-sm-5">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">£</span>
                    </div>
                    <input
                        type="text"
                        id="amount"
                        name="amount"
                        class="form-control"
                        placeholder="-12.34"
                        required="required"
                        aria-label="Start date"
                        aria-describedby="basic-addon1"
                        value="{{ $regular['amount'] }}"
                    >
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="estimated" class="col-sm-3 control-label">Estimated?</label>
            <div class="col-sm-5">
                <input
                    type="checkbox"
                    id="estimated"
                    name="estimated"
                    class="form-check"
                    value="1"
                    @if ($regular['estimated']) checked="checked" @endif
                >
            </div>
        </div>

        @error('remarks')
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

        <div class="form-group row @error('remarks') is-invalid @enderror">
            <label for="remarks" class="col-sm-3 control-label">Remarks</label>
            <div class="col-sm-5">
                <input
                    type="text"
                    id="remarks"
                    name="remarks"
                    class="form-control"
                    placeholder="Anything to add?"
                    value="{{ $regular['remarks'] }}"
                >
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-3 control-label">Transaction Provider</label>
            <div class="col-sm-5">
                <select name="provider_id" id="provider_id">
                    @foreach($providers as $provider)
                        <option
                            value="{{ $provider->id }}"
                            @if ($provider->id == $regular->provider->id) selected="selected" @endif()
                        >{{ $provider->name }}</option>
                    @endforeach()
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="type" class="col-sm-3 control-label">Transaction Type</label>
            <div class="col-sm-5">
                <select name="type" id="type">
                    <option value="dd" @if($regular['type'] == 'dd') selected @endif>Direct Debit</option>
                    <option value="so" @if($regular['type'] == 'so') selected @endif>Standing Order</option>
                    <option value="tfr" @if($regular['type'] == 'tfr') selected @endif>Transfer</option>
                    <option value="csh" @if($regular['type'] == 'csh') selected @endif>Cash</option>
                    <option value="dc" @if($regular['type'] == 'dc') selected @endif>Direct Credit</option>
                    <option value="cp" @if($regular['type'] == 'cp') selected @endif>Card Payment</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="days" class="col-sm-3 control-label">Transaction Type</label>
            <div class="col-sm-5">
                <select name="days" id="days">
                    <option value="1w" @if($regular['days'] == '1w') selected @endif>Weekly</option>
                    <option value="2w" @if($regular['days'] == '2w') selected @endif>Fortnightly</option>
                    <option value="4w" @if($regular['days'] == '4w') selected @endif>Four Weekly</option>
                    <option value="1m" @if($regular['days'] == '1m') selected @endif>Monthly</option>
                    <option value="3m" @if($regular['days'] == '3m') selected @endif>Quarterly</option>
                    <option value="6m" @if($regular['days'] == '6m') selected @endif>Six Monthly</option>
                    <option value="1y" @if($regular['days'] == '1y') selected @endif>Annually</option>
                </select>
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
