@extends('layouts.app')

@section('content')

    <header>
        <h1>Transactions</h1>
        <h2>{{ $provider->name }}</h2>
    </header>

    <section id="transactions">
        <article class="section-body">
            <transaction-list source="/providers/transactions/{{ $provider->id }}"></transaction-list>
        </article>

        <footer>
        </footer>
    </section>

@endsection
