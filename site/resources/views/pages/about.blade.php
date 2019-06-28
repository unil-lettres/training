@extends('layouts.base')
@section('title')
    À propos
    <hr>
@stop
@section('content')
    <div class='about-current'>
        <div class='alert alert-info'>
            Version actuelle : <b>2.0</b>
        </div>
    </div>
    <div class="about-cl">
        <b>Change log :</b>
        <ul class="list-group">
            <li class="list-group-item  list-group-item-success">
                <b>2.0</b><span class="badge">20/07/2019</span>
                <ul>
                    <li>Migration sur stack LAMP</li>
                    <li>Authentification via Shibboleth</li>
                </ul>
            </li>
            <li class="list-group-item">
                <b>1.2</b><span class="badge">15/04/2019</span>
                <ul>
                    <li>Migration framework</li>
                    <li>Mise à jour librairies javascript et adaptations</li>
                </ul>
            </li>
            <li class="list-group-item">
                <b>1.1</b><span class="badge">04/12/2017</span>
                <ul>
                    <li>Amélioration de l'administration</li>
                    <li>Modification du processus d'authentification</li>
                    <li>Ajout d'un champ document au modèle de demande de formation</li>
                    <li>Ajout de nouvelles offres et formations en page d'accueil</li>
                </ul>
            </li>
            <li class="list-group-item">
                <b>1.0</b><span class="badge">20/01/2017</span>
                <ul>
                    <li>Suivi des versions</li>
                    <li>Réorganisation page accueil et menus</li>
                    <li>Automatisation date de fin des formations</li>
                </ul>
            </li>
            <li class="list-group-item list-group-item-default">
                <b>0.1</b><span class="badge">20/12/2016</span>
                <ul>
                    <li>Authentification via LDAP et récupération des adresses de courriel</li>
                    <li>Gestionnaire de version</li>
                    <li>Simplification des demandes et de leur gestion
                        <ul>
                            <li>Indication manuelle du profil de demande</li>
                            <li>Backend : gestion des décisions des demandes directement dans les "fiches demandes"</li>
                        </ul>
                    </li>
                    <li>Divers bug</li>
                </ul>
            </li>
        </ul>
    </div>
@stop
