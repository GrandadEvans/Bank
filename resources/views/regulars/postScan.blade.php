@extends('layouts.app')

@section('content')

    <header>
        <h1>Post Regular Scan Report</h1>
    </header>

    <section id="report-summary">
        <article class="section-body">

            <div class="container">
                <p>You recently requested a scan to find new regular payment.</p>
                <p>Good news: The scan is complete
                    @if (count($count = $regulars >0))
                        and it looks like there are {$count} possible new regular transaction for you to review.
                    @else
                        , alas it looks like I couldn&#039;t find any new regular payments.
                    @endif
                </p>
                <form id="review-regular-scan-button-form">
                    <button-component
                        :label="review-regular-scan"
                        :text="Review Your New Regulars"
                        :id="review-regular-scan"
                        :form-id="review-regular-scan-button-form"/>
                </form>

            </div>
            {{--            <transaction-table source="/transactions/all" search="{{$search ?? ''}}">--}}
        </article>

        <footer>
        </footer>
    </section>

@endsection
