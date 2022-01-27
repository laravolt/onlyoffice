<x-volt-app title="Templates">
    <x-slot name="actions">
        <x-volt-link-button :label="__('Tambah')" url="{{ route('onlyoffice::template.create', $id) }}" icon="plus"></x-volt-link-button>
    </x-slot>

    @livewire('template-table', ['folderId' => $id, 'token' => $token])

    {!! form()->open()->delete()->addClass('form-delete') !!}
    {!! form()->close() !!}

    @push('script')
        <script>
            $(document).ready(function() {
                $(".link-delete").click(function() {
                    const {id} = $(this).data();
                    $(".form-delete").attr("action", `/{{ $id }}/template/${id}`);
                    $(".form-delete").submit();
                })
            })
        </script>
    @endpush

</x-volt-app>
