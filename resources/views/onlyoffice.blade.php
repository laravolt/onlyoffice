@push('head')
    <script id="scriptApi" type="text/javascript" src="{!! $uri_onlyoffice !!}/web-apps/apps/api/documents/api.js"></script>
@endpush

<div style="height: 100vh">
    @if ($isLogin)
        @if ($api)
            @if ($api->successful())
                <div id="placeholder" style="height: 100%"></div>
            @else
                <div class="error">
                    Page 404 Not Found
                </div>
            @endif
        @endif
    @else
        <div class="ui two column centered grid">
            <div class="column">
                {!! form()->post()->route('onlyoffice.login') !!}
                <div class="field">
                    {!! form()->input('email')->placeholder('email') !!}
                </div>
                <div class="field">
                    {!! form()->input('password')->type("password")->placeholder('passowrd') !!}
                </div>
                <div class="field">
                    {!! form()->submit('login')->addClass('fluid') !!}
                </div>
                {!! form()->close() !!}
            </div>
        </div>
    @endif
</div>

@push('style')
    <style>
        .error {
            height: 300px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 800;
            font-size: 3rem;
        };
    </style>
@endpush

@push('script')
    <script>
        @if ($api)
            @if($api->successful())
                const api = JSON.parse(@json($document));
                new DocsAPI.DocEditor("placeholder", api.response);
            @endif
        @endif
    </script>
@endpush
