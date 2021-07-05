@extends('layouts.app')

@section('content')

    <h1>Tags</h1>

    <table id="TagsTable" class="table-bordered table-hover table-striped" style="width: 100%">
        <thead>
            <tr>
                <th>ID</th>
                <td>Tag</td>
                <td>Default Colour</td>
                <td>Icon</td>
                <td><i class="fas fa-edit"></i></td>
                <td><i class="fas fa-trash"></i></td>
            </tr>
        </thead>
        <tbody>
        @foreach($tags as $tag)
            <tr>
                <td>{{ $tag->id }}</td>
                <td>{{ $tag->tag }}</td>
                <td
                    class="dynamic_background_colour"
                    style="background-color: {{ $tag->default_color }}; color: {{ $tag->contrasted_tag_color }}">{{ $tag->default_color }}</td>
                <td class="icon"><i class="fa fa-{{ $tag->icon }}"></i>{{ $tag->icon }}</td>
                <td class="text-center">
                    <form action="{{ route('tags.edit', [$tag->id]) }}" method="GET" class="form-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" id="update-form-button-{{ $tag->id }}"><i class="fas fa-edit"></i></button>
                    </form>
                </td>
                <td class="text-center">
                    <form action="{{ route('tags.delete', [$tag->id]) }}" method="POST" class="form-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="delete-form-button-{{ $tag->id }}"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
@endsection
