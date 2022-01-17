<x-volt-app title="Templates">
    <x-slot name="actions">
        <x-volt-link-button :label="__('Tambah')" url="{{ route('onlyoffice::template.create', $id) }}" icon="plus"></x-volt-link-button>
    </x-slot>

    {{-- {!! $table !!} --}}

</x-volt-app>
