<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="user" content="{{ Auth::user() }}">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Scripts -->
    @if (auth()->check())
    <script src="{{ asset('/js/manifest.js') }}"></script>
    <script src="{{ asset('/js/vendor.js') }}"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="{{ asset('/js/app.js') }}"></script>
    @endif

    <!-- Styles -->
    <link href="{{ asset('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    @include('partials.navbar')

    <div class="container-fluid" id="container-fluid">
        <div class="row" id="sidebar-surround">
            @if (auth()->check())
                @include('partials.sidebar')
            @endif
            <main id="app" class="col-md-10 ml-sm-auto col-lg-10 px-md-4" role="main">
                @yield('content')
                @if (auth()->check())
                    <add-tag-modal></add-tag-modal>
                    <add-provider-modal></add-provider-modal>
                    <add-similar-transactions-modal></add-similar-transactions-modal>
                    <add-remarks-modal></add-remarks-modal>
                @endif
            </main>
        </div>
    </div>

@if (session()->has('alert'))
    @php
        $flashMessage = session()->get('alert')
    @endphp
    <script>
        swal.fire({
            @foreach($flashMessage as $key => $value)
                '{{ $key }}': '{!! e($value) !!}',
            @endforeach
        });

    </script>
    @php
        session()->forget('alert')
    @endphp
@endif

@section('bottom-js')
@endsection

</body>
</html>
