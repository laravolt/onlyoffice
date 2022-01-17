<x-volt-app title="Show Template">
    <x-slot name="actions">
        <x-volt-backlink url="{{ route('onlyoffice::template.index', $id) }}">Kembali ke Templates</x-volt-backlink>
    </x-slot>

    <x-onlyoffice :id="$template" readonly></x-onlyoffice>

</x-volt-app>
