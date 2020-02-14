@extends(backpack_view('blank'))

@php
@endphp

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">
                    Bonjour {{ backpack_user()->name }}
                </h5>
                <div class="card-body">
                    <a href="{{ route('home') }}"><i class="nav-icon fa fa-home"></i> <span>Retourner à l'application</span></a><br>
                    <a href="{{ backpack_url('user') }}"><i class="nav-icon fa fa-user"></i> <span>Gérer les utilisateurs</span></a> ({{ $users->count() }})
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <h5 class="card-header">
                    <a href='{{ backpack_url('request') }}'>Demandes</a> ({{ $requests->count() }})
                </h5>
                <div class="card-body">
                    @if($requests->count())
                        <div>
                            <a href='{{ backpack_url('request/'.$requests->last()->id.'/edit') }}'>{{ $requests->last()->name }}</a>
                            <span>(créée le {{ $requests->last()->created_at->format('d m Y') }}</span>@if($requests->last()->user)<span> par "{{ $requests->last()->user->name }}"<span>@endif<span>)</span>
                        </div>
                        @if($requests->count() > 1)
                            <div>...</div>
                        @endif
                    @else
                        <div class="text-secondary">
                            Pas de demandes pour l'instant
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <h5 class="card-header">
                    <a href='{{ backpack_url('training') }}'>Formations</a> ({{ $trainings->count() }})
                </h5>
                <div class="card-body">
                    @if($trainings->count())
                        <div>
                            <a href='{{ backpack_url('training/'.$trainings->last()->id.'/edit') }}'>{{ $trainings->last()->name }}</a>
                            (créée le {{ $trainings->last()->created_at->format('d m Y') }})
                        </div>
                        @if($trainings->count() > 1)
                            <div>...</div>
                        @endif
                    @else
                        <div class="text-secondary">
                            Pas de formations pour l'instant
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
