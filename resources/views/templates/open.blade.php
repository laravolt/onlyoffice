<x-volt-app title="Open Template">
    <x-slot name="actions">
        <x-volt-backlink url="{{ route('onlyoffice::template.index', $id) }}">Kembali ke Templates</x-volt-backlink>
    </x-slot>

    @if ($open == "edit")
        <x-onlyoffice :id="$template"></x-onlyoffice>
    @else
        <x-onlyoffice :id="$template" readonly></x-onlyoffice>
    @endif

</x-volt-app>
