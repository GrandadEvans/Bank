@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="card">

            <div class="card-header">
                Import File
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
{{--            <div class="card-body">--}}
{{--                <div id="curve_chart" style="width: 900px; height: 500px"></div>--}}
{{--            </div>--}}

        <div class="card">
            <div class="card-header">
                Links
            </div>
            <div class="card-body">
                <p>Transactions:</p>
                <ul>
                    <li><a href="{{ route('transactions.index') }}">List</a></li>
                    <li><a href="{{ route('transactions.create') }}">Add</a></li>
                </ul>

                <p>Regulars:</p>
                <ul>
                    <li><a href="{{ route('regulars.index') }}">List</a></li>
                    <li><a href="{{ route('regulars.create') }}">Add</a></li>
                </ul>

                <p>Providers:</p>
                <ul>
                    <li><a href="{{ route('providers.index') }}">List</a></li>
                    <li><a href="{{ route('providers.create') }}">Add</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
