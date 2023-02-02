<div class="m-t-10 m-b-10 p-l-10 p-r-10 p-t-10 p-b-10">
	<div class="row">
		<div class="col-md-12 m-4">
            <div class="mb-2">
                <b>Nom:</b> {{ $entry->name ?? '-' }}
            </div>
            <div class="mb-2">
                <b>Description:</b> {!! $entry->description ?? '-' !!}
            </div>
            <div class="mb-2">
                <b>Date dépot:</b> {{ $entry->filling_date ?? '-' }}
            </div>
            <div class="mb-2">
                <b>Thème:</b> {{ $entry->theme ?? '-' }}
            </div>
            <div class="mb-2">
                <b>Délai production:</b> {{ $entry->deadline ?? '-' }}
            </div>
            <div class="mb-2">
                <b>Niveau requis:</b> {{ $entry->level ?? '-' }}
            </div>
            <div class="mb-2">
                <b>Remarques:</b> {!! $entry->comments ?? '-' !!}
            </div>
            <div class="mb-2">
                <b>Mail contact:</b> {{ $entry->email ?? '-' }}
            </div>

            <div class="mb-2">
                <b>École doctorale:</b> {{ $entry->doctoral_school ?? '-' }}
            </div>
            <div class="mb-2">
                <b>Fns:</b> {{ \App\Helpers\Helpers::checkboxToString($entry->fns) }}
            </div>
            <div class="mb-2">
                <b>Doctorat statut:</b> {{ $entry->doctoral_status ?? '-' }}
            </div>
            <div class="mb-2">
                <b>Niveau actuel:</b> {{ $entry->doctoral_level ?? '-' }}
            </div>
            <div class="mb-2">
                <b>Produits testés:</b> {{ $entry->tested_products ?? '-' }}
            </div>

            <div class="mb-2">
                <b>Seul ou avec d'autres enseignants:</b> {{ \App\Helpers\Helpers::checkboxToString($entry->teachers_nbr) }}
            </div>
            <div class="mb-2">
                <b>Avec un ou des étudiants:</b> {{ \App\Helpers\Helpers::checkboxToString($entry->students_nbr) }}
            </div>
            <div class="mb-2">
                <b>Intervention pour toute une classe, pendant les cours:</b> {{ \App\Helpers\Helpers::checkboxToString($entry->action_type) }}
            </div>

            <div class="mt-4">
                <a href='{{ backpack_url('request/'.$entry->id.'/edit') }}'>Plus...</a>
            </div>
        </div>
	</div>
</div>
<div class="clearfix"></div>
