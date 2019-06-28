@extends('layouts.base')
@section('content')
    <div class="container home-content">
        <div class="row">
            <div class="col-sm-10" style="color:#828282;font-weight: 700;font-size: 18px;margin-bottom: 20px;" >
                Développement des compétences techniques en Faculté des Lettres
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5"  >
                <div class="row">
                    <div class="col-sm-12">
                        <h2 style="font-weight: bold;">Demandes de formation</h2>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-sm-10" style="margin-top:20px;font-size: 13px;overflow-wrap: break-word;">
                        La Faculté des Lettres de l'Université de Lausanne encourage ses membres, étudiant-e-s en
                        particulier, à développer des compétences analytiques et techniques dans le but de mettre en
                        forme des informations pour en faciliter la compréhension.
                    </div>
                </div>
                <div class="row" >
                    <div class="col-sm-10">
                        <div style="margin-top:40px;font-size: 24px;font-weight: 700;">Si vous êtes...</div>
                        <div class="panel-group" id="accordion" style="margin-top:20px;">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                            ...étudiant-e</a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse">
                                    <div class="panel-body" style="font-size: 12px;font-weight: normal;margin: 15px 0 15px;">
                                        Si un document ou une présentation que vous réalisez dans le cadre de vos études peut
                                        être rendu plus clair ou plus percutant par l'ajout d'un élément visuel / d'un
                                        enregistrement audio / d'un catalogue d'images, nous pouvons vous aider. Nous vous
                                        indiquerons comment identifier et structurer les informations pertinentes et vous
                                        orienterons vers des outils faciles à utiliser.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                            ...enseignant-e</a>
                                    </h4>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse">
                                    <div class="panel-body" style="font-size: 12px;font-weight: normal;margin: 15px 0 15px;">
                                        Si vous souhaitez que vos étudiants intègrent des éléments visuels ou audio / créent
                                        seuls ou ensemble un catalogue d'images dans leurs travaux écrits ou oraux, nous
                                        pouvons vous aider à formuler votre exigence et vous offrir une formation de base
                                        sur l'outil et/ou les modalités d'évaluation.
                                        <ul>
                                            <li>
                                                Si seul un-e étudiant-e est concerné, nous travaillerons individuellement ou
                                                en petits groupes, avec vous si vous le souhaitez.
                                            </li>
                                            <li>Si tous vos étudiants sont concernés, nous pouvons organiser une initiation en classe.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                            ...chercheur/se,doctorant-e,etc.</a>
                                    </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse">
                                    <div class="panel-body" style="font-size: 12px;font-weight: normal;margin: 15px 0 15px;">
                                        Si c'est en tant que chercheur/se que vous avez des besoins de formation aux démarches
                                        et outils informatiques, il est possible qu'aucune des offres existantes ne convienne.
                                        Communiquez-nous quand même votre demande.
                                        <ul>
                                            <li>Si nous pouvons vous aider, nous le ferons volontiers.</li>
                                            <li>Sinon, nous vous orienterons vers les services ou les collègues qui seraient
                                                en mesure de le faire.</li>
                                            <li>Si des besoins convergents sont identifiés, nous en informerons les
                                                intervenants en soutien à la recherche et les écoles doctorales.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12" style="margin-top: 40px;">
                        <a href="{{ route('request.create') }}" class="btn btn-success btn-lg btn-request" role="button" style="width:80%;">Je dépose une demande</a>
                    </div>
                </div>
            </div>

            <div class="trainings-content col-sm-7">
                <div class="trainings-content">
                    <div class="row">
                        <div class="col-xs-7 col-sm-4 col-lg-4">
                            <div class="img-circle" style="background-color: #FFF078;">
                                <div><b>#1 FORMATION</b></div>
                                <div><b>Présenter visuellement des informations</b></div>
                                <div>Chronologies, cartes géo., infographies, ...</div>
                            </div>
                        </div>
                        <div class="col-xs-7 col-sm-4 col-lg-4">
                            <div class="img-circle" style="background-color: #00CCCC;">
                                <div><b>#2 FORMATION</b></div>
                                <div><b>Créer, optimiser et diffuser des informations sous forme audio</b></div>
                            </div>
                        </div>
                        <div class="col-xs-7 col-sm-4 col-lg-4">
                            <div class="img-circle" style="background-color: #E26498;">
                                <div><b>#3 FORMATION</b></div>
                                <div><b>Créer des catalogues d'images accessibles en ligne</b></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-7 col-sm-4 col-lg-4">
                            <div class="img-circle" style="background-color: #F38574;">
                                <div><b>#4 FORMATION</b></div>
                                <div><b>Documenter ses compétences</b></div>
                                <div>Réfléchir à son parcours de formation et mettre en valeur ses connaissances</div>
                            </div>
                        </div>
                        <div class="col-xs-7 col-sm-4 col-lg-4">
                            <div class="img-circle" style="background-color: #B7A1AA;">
                                <div><b>#5 OFFRE</b></div>
                                <div><b>Enseigner avec des outils informatiques</b></div>
                                <div>Identifier les outils d’enseignement adéquats et les maîtriser : Moodle, Xerte, CORREX, Outil Voc, etc.</div>
                            </div>
                        </div>
                        <div class="col-xs-7 col-sm-4 col-lg-4">
                            <div class="img-circle" style="background-color: #BDDD37;">
                                <div><b>#6 OFFRE</b></div>
                                <div><b>Bilan de compétences informatiques</b></div>
                                <div>Établir un plan de formation en autonomie</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="trainings-infos row">
            <div class="col-sm-5 col-md-5 col-lg-5" style="margin-top:60px;"></div>
            <div class="col-xs-11 col-sm-7 col-md-6 col-lg-6" style="font-size: 13px;">
                Bien qu'organisées sur demande, certaines formations peuvent accueillir des participants
                supplémentaires. Si vous souhaitez vous joindre à une offre listée ci-dessous, veuillez le
                mentionner dans votre demande.
            </div>
        </div>
    </div>
@stop
