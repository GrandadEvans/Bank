@extends('layouts.app')

@section('content')

    <header>
        <h1>Transactions</h1>
    </header>

    <section id="transactions">
        <article class="section-body">
            <transaction-table source="/transactions/all" search="{{$search ?? ''}}">
        </article>

        <footer>
        </footer>
    </section>

@endsection
