@extends('layouts.form')
@section('card')
    @component('components.card')
        @slot('title')
            @lang('Modifier un professeur')
        @endslot
        <form method="POST" action="{{ route('prof.update', $prof->id) }}">
            @csrf
            @method('PUT')
            @include('partials.form-group', [
                'title' => __('Nom'),
                'type' => 'text',
                'name' => 'name',
                'value' => $prof->name,
                'required' => true,
                ])
            @component('components.button')
                @lang('Envoyer')
            @endcomponent
        </form>
    @endcomponent
@endsection
