@extends('layouts.app')

@section('content')

    <header>
        <h1>Import Transactions (multiple providers available)</h1>
    </header>

    <section id="providers">
        <article class="section-body">
            <p>
                There were transactions that can be matched to more than one provider.<br />
                Please can you select which provider is the correct match?
            </p>
            <p>
                You can also choose to add a regular expression to the provider so 
                that this provider is more likely to be chosen in future.
            </p>
            @foreach($multipleProviderMatches as $transaction)
                <div class="card" style="display: inline-flex">
                    <div class="card-header">
                        <p>Entry: {{ $transaction['entry'] }}<br />
                            Amount: {{ $transaction['amount'] }}</p>
                    </div>
                    <div class="card-body">
                        <table id="transaction-{{ $transaction['id'] }}"  cellpadding="5px" class="transactionProviderTable">
                            <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Provider</th>
                                    <th>Matched<br />Regular<br />Expresssion</th>
                                    <th>Remarks</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction['providers'] as $provider)
                                    <tr>
                                        <td>
                                            <figure>
                                                <img
                                                    src="{{ $provider['logo'] }}" 
                                                    alt="{{ $provider['name'] }}"
                                                    width="75px"
                                                    height="auto" />
                                            </figure>
                                        </td>
                                        <td>{{ $provider['name'] }}</td>
                                        <td>{!! nl2br($provider['regular_expressions']) !!}</td>
                                        <td>{{ $provider['remarks'] }}</td>
                                        <td>
                                            <input
                                                type="button"
                                                name="transaction-{{ $transaction['id'] }}"
                                                value="Choose this provider"
                                                class="provider_regular_expression_button"
                                            />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
    
        </article>
        
        <footer>
        </footer>
    </section>

@endsection

<style>
    .card {
        display: inline-flex;
    }

.transactionProviderTable,
.transactionProviderTable th,
.transactionProviderTable td {
    border: 1px solid #ccc;
}
</style>