@extends('layouts.base')
@section('title')
    Nouvelle demande
    <hr>
@stop
@section('content')
    <div class="col-12">
        <div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif
            <form method="post" action="{{ route('request.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Formation demandée:</label>
                    <input type="text" class="form-control" name="name"/>
                </div>

                <div class="form-group">
                    <label for="theme">Thème du travail demandé:</label>
                    <input type="text" class="form-control" name="theme"/>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" name="description"></textarea>
                </div>

                <div class="form-group">
                    <label for="deadline">Délai de production du travail:</label>
                    <input type="text" class="date form-control" name="deadline">
                </div>

                <div class="form-group">
                    <label for="level">Niveau de connaissance préalable:</label>
                    <input type="text" class="form-control" name="level"/>
                </div>

                <div class="form-group">
                    <label for="applicants">Demandeur(s):</label>
                    <input type="text" class="form-control" name="applicants"/>
                </div>

                <div class="form-group">
                    <label for="contact">Mail de contact pour le suivi:</label>
                    <input type="text" class="form-control" name="contact"/>
                </div>

                <div class="form-group">
                    <label for="comments">Remarques éventuelles:</label>
                    <textarea class="form-control" name="comments"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Envoyer</button>
            </form>
        </div>
    </div>
@stop
@section('scripts')
    <script type="text/javascript">
        $('.date').datepicker({ dateFormat: 'yy-mm-dd' });
    </script>
@stop
