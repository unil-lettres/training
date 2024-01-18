@extends('layouts.base')

@section('title')
    Liste des demandes envoyées
    <hr>
@stop

@section('content')
    @if($requests->count())
        <table class="table table-striped table-bordered">
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
                        <td>{{ Str::limit($request->name, 40) }}</td>
                        <td>{{ Str::limit(strip_tags($request->description), 75) }}</td>
                        <td>
                            @if($request->filling_date)
                                {{ $request->filling_date->format('d-m-Y H:i:s') }}
                            @endif
                        </td>
                        <td>{{ Helpers::requestStatus($request->status_admin) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Pas de demande déposée.</p>
    @endif
@stop
