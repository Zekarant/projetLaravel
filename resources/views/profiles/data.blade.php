@extends('layouts.app')
@section('content')
    <main class="container-fluid">
        <h1>@lang('Export des données personnelles')</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">@lang('A propos')</h5>
                <table class="table">
                    <tr>
                        <td>@lang('Rapport généré pour : ')</td>
                        <td>{{ $user->email }} - {{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>@lang('Pour le projet BTS :')</td>
                        <td>Classe Inverse</td>
                    </tr>
                    <tr>
                        <td>@lang('Le :')</td>
                        <td>{{ now()->formatLocalized('%x') }}</td>
                    </tr>
                </table>
                <em>@lang('Vous pouvez enregistrer cette page pour conserver vos données en utilisant le menu de votre navigateur.')</em>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">@lang('Utilisateur')</h5>
                <table class="table">
                    <tr>
                        <td>@lang("ID : ")</td>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <td>@lang("Nom de connexion : ")</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>@lang("Email :")</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td>@lang("Date d'inscription :")</td>
                        <td>{{ $user->created_at->formatLocalized('%x') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <br>
    </main>
@endsection
