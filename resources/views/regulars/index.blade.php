@extends('layouts.app')

@section('content')

    <h1>Regular Transactions</h1>

    <div class="card">
        <div class="card-header">
            <p>Total for all regular transactions</p>
        </div>
        <div class="card-body">
            <p>Total for all regular transactions: <span class="strong">{{ \Bank\BaseModel::formatMoneyForTable($total) }}</span></p>
            <p class="help-note">This does not include all transactions that can not be predicted<br />
            all-though, I will try in the future</p>
        </div>
    </div>

    <table id="regularsTable" class="table-bordered table-hover table-striped" style="width: 100%">
        <thead>
            <tr>
{{--                <th>ID</th>--}}
                <td>Next Due</td>
                <td>Last Updated</td>
                <td>Remarks</td>
                <td>Frequency</td>
                <td>Amount</td>
                <td>Description</td>
                <td>Provider</td>
                <td><i class="fas fa-edit"></i></td>
                <td><i class="fas fa-trash"></i></td>
            </tr>
        </thead>
        <tbody>
        @foreach($transactions as $transaction)
            <tr>
{{--                <td>{{ $transaction->id }}</td>--}}
                <td>{{ Dates::formatDateForTable($transaction->nextDue) }}</td>
                <td>{{ Dates::formatDateForTable($transaction->lastRotated) }}</td>
                <td>{{ Str::limit($transaction->remarks, 40) }}</td>
                <td>Every {{ Dates::makeShortDurationReadable($transaction->days) }}</td>
                <td class="amount">@if ($transaction->estimated) <span class="strong">c.</span> @endif {{ $transaction->formattedAmount }}</td>
                <td>{{ Str::limit($transaction->description, 30) }}</td>
                <td>@if (is_object($transaction->provider) && $transaction->provider->name) {{ $transaction->provider->name }} @endif()</td>
                <td class="text-center">
                    <form action="{{ route('regulars.edit', [$transaction->id]) }}" method="GET" class="form-inline">
                        @csrf
                        @method('GET')
                        <button type="submit" id="update-form-button-{{ $transaction->id }}"><i class="fas fa-edit"></i></button>
                    </form>
                </td>
                <td class="text-center">
                    <form action="{{ route('regulars.delete', [$transaction->id]) }}" method="POST" class="form-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="delete-form-button-{{ $transaction->id }}"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
@endsection
