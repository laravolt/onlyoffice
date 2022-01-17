<x-volt-app title="Create Template">
    <x-slot name="actions">
        <x-volt-backlink url="{{ route('onlyoffice::template.index', $id) }}">Kembali ke Templates</x-volt-backlink>
    </x-slot>

    <div class="ui two column centered grid">
        <div class="column">
            {!! form()->post(route('onlyoffice::template.store', $id))->multipart() !!}
            <div class="field">
                {!! form()->file('file')->placeholder('document') !!}
            </div>
            <div class="field center-object">
                {!! form()->submit('submit') !!}
            </div>
            {!! form()->close() !!}
        </div>
    </div>

    @push('style')
        <style>
            .center-object {
                text-align: center;
            }
        </style>
    @endpush

</x-volt-app>
