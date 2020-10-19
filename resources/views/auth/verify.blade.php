@extends('layouts.app')

@section('card')
    @component('components.card')

        @slot('title')
            @lang('Vérification de votre adresse mail')
        @endslot

        @if(session('resend'))
            <div class="alert alert-success" role="success">
                @lang('Un nouveau lien de vérification vous a été envoyé sur votre adresse mail !')
            </div>
        @endif

        <p>@lang("Pour accéder à cette page, vous devez utiliser le lien de vérification que nous vous avons envoyé par emails.")</p>
        @lang("Si vous n'avez pas reçu l'email, alors ") <a href="{{ route('verification.resend') }}">@lang('cliquez ici pour en recevoir un nouveau')</a>
    @endcomponent
@endsection
