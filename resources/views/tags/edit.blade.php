@extends('layouts.app')

@section('content')

    <form
        action="{{ route('tags.update', [$tag->id]) }}"
        method="POST"
        class="form-horizontal col-md-6 offset-3"
        id="tags__edit"
        tag="tags__edit"
    >

        <h1>Edit Retailer/Supplier</h1>
        <h2>{{ $tag->tag }}</h2>

        @csrf
        @method('PUT')

        @include('partials._errors')

        @include('partials.form_fields._input_text', [
            'name'        => 'tag',
            'placeholder' => 'Clothing etc',
            'required'    => true,
            'value'       => $tag->tag
        ])

        @include('partials.form_fields._input_text', [
            'name' => 'default_color',
            'placeholder' => 'The hexidecimal color code starting with "#"',
            'label' => 'Default tag color',
            'value'       => $tag->default_color
        ])

        @include('partials.form_fields._input_text', [
            'name' => 'icon',
            'placeholder' => 'A valid Font-awesome icon',
            'label' => 'Font-Awesome Icon',
            'value'       => $tag->icon
        ])

        @include('partials.form_fields._button_submit', [
            'text' => 'Update Tag'
        ])

    </form>
@endsection
