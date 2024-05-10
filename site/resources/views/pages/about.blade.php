@extends('layouts.base')

@section('title')
    À propos
    <hr>
@stop

@section('content')
    <div class="about-cl">
        <p class="text-secondary">Cette page ne répertorie que les évolutions applicatives majeures.</p>

        <ul class="list-group">
            <li class="list-group-item">
                <b>2.34</b><span class="text-black-50 ms-2">10/05/2024</span>
                <ul>
                    <li>Mise a jour de l'application (Laravel 11)</li>
                    <li>Nouvelle structure <a href="https://laravel.com/docs/11.x/structure" target="_blank">https://laravel.com/docs/11.x/structure</a></li>
                </ul>
            </li>
            <li class="list-group-item">
                <b>2.33</b><span class="text-black-50 ms-2">14/04/2023</span>
                <ul>
                    <li>Mise a jour de l'application (Laravel 10)</li>
                </ul>
            </li>
            <li class="list-group-item">
                <b>2.31</b><span class="text-black-50 ms-2">14/04/2022</span>
                <ul>
                    <li>Mise a jour de l'application (Laravel 9)</li>
                    <li>Admin: ajout d'un tri par défaut pour "Status" & "Type"</li>
                </ul>
            </li>
            <li class="list-group-item">
                <b>2.22</b><span class="text-black-50 ms-2">17/09/2020</span>
                <ul>
                    <li>Mise a jour de l'application (Laravel 8)</li>
                    <li>Admin: tri des requêtes par date de création</li>
                </ul>
            </li>
            <li class="list-group-item">
                <b>2.13</b><span class="text-black-50 ms-2">06/03/2020</span>
                <ul>
                    <li>Mise a jour de l'application (Laravel 7)</li>
                </ul>
            </li>
            <li class="list-group-item">
                <b>2.1</b><span class="text-black-50 ms-2">18/09/2019</span>
                <ul>
                    <li>Mise a jour de l'application (Laravel 6)</li>
                </ul>
            </li>
            <li class="list-group-item">
                <b>2.0</b><span class="text-black-50 ms-2">20/07/2019</span>
                <ul>
                    <li>Migration sur stack LAMP & Laravel</li>
                    <li>Authentification via Shibboleth</li>
                </ul>
            </li>
            <li class="list-group-item">
                <b>1.1</b><span class="text-black-50 ms-2">04/12/2017</span>
                <ul>
                    <li>Amélioration de l'administration</li>
                    <li>Modification du processus d'authentification</li>
                    <li>Ajout d'un champ document au modèle de demande de formation</li>
                    <li>Ajout de nouvelles offres et formations en page d'accueil</li>
                </ul>
            </li>
            <li class="list-group-item">
                <b>1.0</b><span class="text-black-50 ms-2">20/01/2017</span>
                <ul>
                    <li>Suivi des versions</li>
                    <li>Réorganisation page accueil et menus</li>
                    <li>Automatisation date de fin des formations</li>
                </ul>
            </li>
            <li class="list-group-item list-group-item-default">
                <b>0.1</b><span class="text-black-50 ms-2">20/12/2016</span>
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
