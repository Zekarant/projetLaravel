@extends('layouts.form')

@section('card')

    @component('components.card')

        @slot('title')
            @lang('Renouvellement de votre mot de passe')
        @endslot

        <form method="POST" action="{{ route('password.request') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value=""{{ $token }}">

            @include('partials.form-group', [
                'title' => __('Adresse email :'),
                'type' => 'email',
                'name' => 'email',
                'required' => true,
            ])

            @include('partials.form-group', [
                'title' => __('Nouveau mot de passe :'),
                'type' => 'password',
                'name' => 'password',
                'required' => true,
            ])

            @include('partials.form-group',[
                'title' => __('Confirmation du nouveau mot de passe :'),
                'type' => 'password',
                'name' => 'password_confirmation',
                'required' => true,
            ])

            @component('components.button')
                @lang('Renouveller mon mot de passe')
            @endcomponent
        </form>
    @endcomponent
@endsection
