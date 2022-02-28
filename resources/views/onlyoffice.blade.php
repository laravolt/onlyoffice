<script id="scriptApi" type="text/javascript" src="{!! $docService !!}"></script>

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
                {!! form()->post()->route('onlyoffice::login') !!}
                <div class="field">
                    {!! form()->input('email')->placeholder('email') !!}
                </div>
                <div class="field">
                    {!! form()->input('password')->type("password")->placeholder('passowrd') !!}
                </div>
                <div class="field">
                    {!! form()->submit('Connect')->addClass('fluid') !!}
                </div>
                {!! form()->close() !!}
            </div>
        </div>
    @endif
</div>

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

<script>
    var onRequestClose = function () {
        if (window.opener) {
            window.close();
            return;
        }
        docEditor.destroyEditor();
    };

    @if ($api)
        @if($api->successful())
            const api = JSON.parse(@json($document));
            const config = {...api.response, "events": {"onRequestClose": onRequestClose}};
            new DocsAPI.DocEditor("placeholder", config);
        @endif
    @endif
</script>
