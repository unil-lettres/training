@extends('layouts.base')
@section('title')
    Nouvelle demande
    <hr>
@stop
@section('content')
    <div class="col-12">
        <div>
            <div id="request-dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Déposer votre demande en tant que
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" data-type="student">Étudiant</a>
                    <a class="dropdown-item" href="#" data-type="researcher">Chercheur/Doctorant</a>
                    <a class="dropdown-item" href="#" data-type="teacher">Enseignant</a>
                </div>
            </div>
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
                <div id="request-student">
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
                </div>
                <div id="request-researcher">
                    <hr>
                    <div class="form-group">
                        <label for="doctoral_school">École doctorale:</label>
                        <input type="text" class="form-control" name="doctoral_school"/>
                    </div>

                    <div class="form-group">
                        <label for="fns">Employé de projet FNS:</label>
                        <input type="checkbox" id="scales" name="fns">
                    </div>

                    <div class="form-group">
                        <label for="doctoral_status">Début / milieu / fin de doctorat:</label>
                        <input type="text" class="form-control" name="doctoral_status"/>
                    </div>

                    <div class="form-group">
                        <label for="doctoral_level">Niveau de connaissances informatiques:</label>
                        <input type="text" class="form-control" name="doctoral_level"/>
                    </div>

                    <div class="form-group">
                        <label for="tested_products">Produits déjà testés:</label>
                        <input type="text" class="form-control" name="tested_products"/>
                    </div>
                </div>
                <div id="request-teacher">
                    <hr>
                    <div class="form-group">
                        <label for="teachers_nbr">Seul ou avec d'autres enseignants:</label>
                        <input type="checkbox" id="scales" name="teachers_nbr">
                    </div>

                    <div class="form-group">
                        <label for="students_nbr">Avec un ou des étudiants:</label>
                        <input type="checkbox" id="scales" name="students_nbr">
                    </div>

                    <div class="form-group">
                        <label for="action_type">Intervention pour toute une classe, pendant les cours:</label>
                        <input type="checkbox" id="scales" name="action_type">
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Envoyer</button>
            </form>
        </div>
    </div>
@stop
@section('scripts')
    <script type="text/javascript">
        $('.date').datepicker({ dateFormat: 'yy-mm-dd' });

        $('.dropdown-menu a').click(function (event) {
            let studentFields = $("#request-student");
            let researcherFields = $("#request-researcher");
            let teacherFields = $("#request-teacher");
            let submitButton = $("form button[type=submit]");

            switch (event.target.dataset.type)
            {
                case "student":
                    studentFields.show();
                    researcherFields.hide();
                    teacherFields.hide();
                    submitButton.show();
                    break;
                case "researcher":
                    studentFields.show();
                    researcherFields.show();
                    teacherFields.hide();
                    submitButton.show();
                    break;
                case "teacher":
                    studentFields.show();
                    researcherFields.hide();
                    teacherFields.show();
                    submitButton.show();
                    break;
            }
        });
    </script>
@stop
