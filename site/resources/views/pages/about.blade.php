@extends('layouts.base')

@section('title')
    À propos
    <hr>
@stop

@section('content')
    <div class="about-cl">
        <ul class="list-group">
            <li class="list-group-item list-group-item-success">
                <b>2.2</b><span class="badge">10/10/2019</span>
                <ul>
                    <li>Ajout d'un tracker d'erreurs en production</li>
                    <li>Mise à jour du framework et des dépendances</li>
                </ul>
            </li>
            <li class="list-group-item">
                <b>2.1</b><span class="badge">18/09/2019</span>
                <ul>
                    <li>Mise à jour du framework et des dépendances</li>
                </ul>
            </li>
            <li class="list-group-item">
                <b>2.0</b><span class="badge">20/07/2019</span>
                <ul>
                    <li>Migration sur stack LAMP & Laravel</li>
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
