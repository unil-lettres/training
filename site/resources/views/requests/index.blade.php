@extends('layouts.base')

@section('title')
    Liste des demandes envoyées
    <hr>
@stop

@section('content')
    @if($requests->count())
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Libellé</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date de dépôt</th>
                    <th scope="col">Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)
                    <tr>
                        <td>{{ $request->name }}</td>
                        <td>{{ $request->description }}</td>
                        <td>{{ $request->filling_date->format('d-m-Y H:i:s') }}</td>
                        <td>{{ $request->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Pas de demande déposée.</p>
    @endif
@stop
