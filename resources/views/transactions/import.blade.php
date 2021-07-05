@extends('layouts.app')

@section('content')

    <header>
        <h1>Import Transactions</h1>
    </header>

    <section id="transactions">
        <article class="section-body">
            <div class="card">
                <div class="card-header">
                    Manually Import Transactions
                </div>
                <div class="card-body">
                    <form
                        class="form"
                        enctype="multipart/form-data"
                        name="statement_upload_form"
                        action="{{ route('transactions.manual_import') }}"
                        method="post"
                    >
                        <div class="file is-boxed is-info is-centered">
                            <label class="file-label">
                                <input class="file-input" type="file" name="file_input" id="file_input">
                            </label>
                            <button
                                class="button"
                                id="import_file_button"
                                name="import_file_button"
                            >Go to it!</button>
                        </div>
    
                        {{ csrf_field() }}
                    </form>
               </div>
            </div>
    
        </article>
        
        <footer>
        </footer>
    </section>

@endsection
