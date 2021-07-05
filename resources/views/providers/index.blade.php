@extends('layouts.app')

@section('content')

    <h1>Product &amp; service providers</h1>

    <table id="providersTable" class="table-bordered table-hover table-striped" style="width: 100%">
        <thead>
            <tr>
                <th>ID</th>
                <td>Name</td>
                <td>Logo</td>
                <td>Remarks</td>
                <td>Regular<br />expressions</td>
                <td>Preferred<br />Payment<br />Method</td>
                <td><i class="fas fa-edit"></i></td>
                <td><i class="fas fa-trash"></i></td>
            </tr>
        </thead>
        <tbody>
        @foreach($providers as $provider)
            <tr>
                <td>{{ $provider->id }}</td>
                <td>{{ $provider->name }}</td>
{{--                <td><img src="{{ $provider->logo }}" style="max-height:1rem;max-width:2rem" /></td>--}}
                <td><img src="/images/logos/company-name.jpg" style="height:1.5rem" /></td>
                <td>{{ Str::limit($provider->remarks, 40) }}</td>
                <td>{{ $provider->regular_expressions }}</td>
                <td>{{ $provider->paymentMethod->method }}</td>
                <td class="text-center">
                    <form action="{{ route('providers.edit', [$provider->id]) }}" method="GET" class="form-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" id="update-form-button-{{ $provider->id }}"><i class="fas fa-edit"></i></button>
                    </form>
                </td>
                <td class="text-center">
                    <form action="{{ route('providers.delete', [$provider->id]) }}" method="POST" class="form-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="delete-form-button-{{ $provider->id }}"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
@endsection
