@extends('layouts.app')

@section('content')
    <form
        action="{{ route('tags.store') }}"
        method="post"
        class="form-horizontal col-md-6 offset-3 @if (!empty($errors->bags)) was-validated @endif"
        id="tags__create"
        name="tags__create"

    >

        <h1>Add a new Tag</h1>

        @csrf

        @include('partials.form_fields._input_text', [
            'name' => 'tag',
            'placeholder' => 'eg Groceries',
            'required' => true
        ])

        @include('partials.form_fields._input_text', [
            'name' => 'default_color',
            'placeholder' => 'The hexidecimal color code starting with "#"',
            'label' => 'Default tag color'
        ])

        @include('partials.form_fields._input_text', [
            'name' => 'icon',
            'placeholder' => 'This must be a font awesome icon',
            'label' => 'Font-Awesome Icon'
        ])

        @include('partials.form_fields._button_submit', [
            'text' => 'Add Tag'
        ])

    </form>
@endsection
