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
        @unless($cours->isEmpty())
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Cours postés par ' . $user->name)</h5>
                    <table class="table" style="margin-bottom: 140px">
                        @foreach($cours as $image)
                            <tr>
                                <td><h3>Cours n°{{ $image->id }}</h3>
                                    <hr>
                                    Matière du cours : {{ $image->matiere->name }}<br/>
                                Cours posté le {{ $image->created_at->formatLocalized('%x') }}</td>
                                <td>
                                    <div class="hover_img">
                                        <span><img src="{{ url('storage/' . $image->name) }}" alt="image" height="150" /></span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        @endunless
    </main>
@endsection
