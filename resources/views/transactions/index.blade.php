@extends('layouts.app')

@section('content')

    <header>
        <h1>Transactions</h1>
    </header>

    <section id="transactions">
        <article class="section-body">
            <bank-transaction-table search="{{$search ?? ''}}"></bank-transaction-table>
        </article>
    </section>

@endsection
