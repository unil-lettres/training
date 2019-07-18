@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-title">Bonjour {{ backpack_user()->name }}</div>
                </div>

                <div class="box-body"><a href="{{ route('home') }}">Retournez à l'application</a></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-title"><a href='{{ backpack_url('request') }}'>Demandes</a> ({{ $requests->count() }})</div>
                </div>

                <div class="box-body">
                    @if($requests->count())
                        <div>
                            <a href='{{ backpack_url('request/'.$requests->last()->id.'/edit') }}'>{{ $requests->last()->name }}</a>
                            <span>(créée le {{ $requests->last()->created_at->format('d m Y') }}</span>@if($requests->last()->user)<span> par "{{ $requests->last()->user->name }}"<span>@endif<span>)</span>
                        </div>
                        @if($requests->count() > 1)
                            <div>...</div>
                        @endif
                    @else
                        <p>Pas de demandes pour l'instant.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-title"><a href='{{ backpack_url('training') }}'>Formations</a> ({{ $trainings->count() }})</div>
                </div>

                <div class="box-body">
                    @if($trainings->count())
                        <div>
                            <a href='{{ backpack_url('training/'.$trainings->last()->id.'/edit') }}'>{{ $trainings->last()->name }}</a>
                            (créée le {{ $trainings->last()->created_at->format('d m Y') }})
                        </div>
                        @if($trainings->count() > 1)
                            <div>...</div>
                        @endif
                    @else
                        <p>Pas de formations pour l'instant.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
