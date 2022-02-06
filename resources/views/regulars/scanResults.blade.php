@extends('layouts.app')

@section('content')

    <header>
        <h1>Potential new regular entries found</h1>
    </header>

    <section id="report-summary">
        <article class="section-body">
            <new-regular-scan-results-table source="/regulars/possible-new"/>
        </article>

        <footer>
        </footer>
    </section>

@endsection
