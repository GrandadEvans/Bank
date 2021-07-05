@extends('layouts.app')

@section('content')

    <section id="predictions">
        <header>
            <h1>Predicted Entries</h1>
        </header>
        <article class="section-body">
            <table
                id="predictions-table"
                class="table table-striped table-bordered table-hover"
                style="width: 98%; margin: 1rem auto;"
            >
                <thead>
                <tr>
                    <th scope="col">Unix</th>
                    <th scope="col">Date</th>
                    <th scope="col">Type</th>
                    <th scope="col">Description</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Remarks</th>
                    <th scope="col"><i class="fas fa-trash"></i></th>
                </tr>
                </thead>
                <tbody>
                @foreach($predictions as $prediction)
                    <tr>
                        <td>{{ $prediction->date->format('U') }}</td>
                        <td>{{ Dates::formatDateForTable($prediction->date) }}</td>
                        <td>{{ $prediction->type }}</td>
                        <td>{{ Str::limit($prediction->entry, 40) }}</td>
                        <td class="amount">{{ \Bank\BaseModel::formatMoneyForTable($prediction->amount) }}</td>
                        <td>{{ Str::limit($prediction->remarks, 40) }}</td>
                        <td class="text-center">
                            <form action="{{ route('transactions.delete', [$prediction->id]) }}" method="POST" class="form-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" id="delete-form-button-{{ $prediction->id }}" class="btn-transparent"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </article>
        <footer>
        </footer>
    </section>

@endsection
