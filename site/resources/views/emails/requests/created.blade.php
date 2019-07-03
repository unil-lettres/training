<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Nouvelle demandede formation</title>
    </head>
    <body>
        <p>Nouvelle demande de formation déposée par "{{ $request->user->name }}".</p>

        <div>
            <b>Identifiant:</b> {{ $request->id }}<br>
            <b>Titre:</b> {{ $request->name }}<br>
            <b>Description:</b> {!! $request->description !!}<br>
        </div>

        <p>Ceci est un mail automatique merci de ne pas y répondre.</p>
    </body>
</html>
