<x-volt-app title="Edit Template">
    <x-slot name="actions">
        <x-volt-backlink url="{{ route('onlyoffice::template.index', $id) }}">Kembali ke Templates</x-volt-backlink>
    </x-slot>

    <x-onlyoffice :id="$template"></x-onlyoffice>

</x-volt-app>
