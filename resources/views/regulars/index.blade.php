@extends('layouts.app')

@section('content')

    <h1>Regular Transactions</h1>

    <div class="card">
        <div class="card-header">
            <p>Total for all regular transactions</p>
        </div>
        <div class="card-body">
            <p>Total for all regular transactions: <span
                    class="strong">&pound;&nbsp;{{ $total }}</span>
            </p>
            <p class="help-note">This does not include all transactions that can not be predicted<br/>
                all-though, I will try in the future</p>
        </div>
    </div>

    <table id="regularsTable" class="table-bordered table-hover table-striped" style="width: 100%">
        <thead>
            <tr>
                <th>ID</th>
                <td>Provider</td>
                <td>Payment Method</td>
                <td>Amount</td>
                <td>Amount Varies</td>
                <td>Period Name</td>
                <td>Period Multiplier</td>
                <td>Remarks</td>
                <td>Next Due</td>
                <td>Last Rotated</td>
                {{--                <td>Entry Text</td>--}}
                <td>Alias</td>
                <td>
                    <font-awesome-icon icon="fa-solid fa-pen-to-square"/>
                </td>
                <td>
                    <font-awesome-icon icon="fa-solid fa-trash-can"/>
                </td>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->provider->name }}</td>
                    <td>{{ $transaction->paymentMethod->method }}</td>
                    <td class="amount">@if ($transaction->amount_varies) <span class="strong">c.</span> @endif {{
                        '£ ' . $transaction->amount }}</td>
                    <td>{{ ($transaction->amount_varies) ? 'Yes' : 'No' }}</td>
                    <td>{{ $transaction->period_name }}</td>
                    <td>{{ $transaction->period_multiplier }}</td>
                    <td>{{ Str::limit($transaction->remarks, 50) }}</td>
                    <td>{{ Dates::formatDateForTable($transaction->next_due) }}</td>
                    <td>{{ (null === $transaction->last_rotated) ? 'Never' : Dates::formatDateForTable($transaction->last_rotated) }}</td>
                    <td class="text-center">
                        <form action="{{ route('regulars.edit', [$transaction->id]) }}" method="GET"
                              class="form-inline">
                            @csrf
                            @method('GET')
                            <button type="submit" id="update-form-button-{{ $transaction->id }}">
                                <font-awesome-icon icon="fa-solid fa-pen-to-square"/>
                            </button>
                        </form>
                    </td>
                    <td class="text-center">
                        <form action="{{ route('regulars.delete', [$transaction->id]) }}" method="POST"
                              class="form-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" id="delete-form-button-{{ $transaction->id }}">
                                <font-awesome-icon icon="fa-solid fa-trash-can"/>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
