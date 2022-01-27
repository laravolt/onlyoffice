<?php

namespace Laravolt\OnlyOffice;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\View\Component;
use Laravolt\OnlyOffice\Models\OnlyOfficeTokens;

class OnlyOfficeComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    private int $id;
    public bool $readOnly;
    public bool $isLogin = false;
    public string $urlOnlyOffice;
    public string $document = "";
    public string $docService = "";
    public $api;

    public function __construct($id, $readonly = false)
    {
        $this->id = $id;
        $this->readOnly = $readonly;
        $this->urlOnlyOffice = config()->get('services.onlyoffice.onlyoffice_url');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $this->checkIsLogin();
        $this->isModeView($this->readOnly);

        return view('onlyoffice::onlyoffice');
    }

    private function fetchApi($id, $token)
    {
        $res = Http::withHeaders(['Authorization' => $token])
                    ->get($this->urlOnlyOffice."/api/2.0/files/file/$id/openedit");

        if ($res->successful()) {
            $this->isLogin = true;
        } elseif ($res->status() == 401) {
            $this->isLogin = false;
        } else {
            $this->isLogin = true;
        }

        return $this->api = $res;
    }

    private function isModeView($mode)
    {
        if ($mode && $this->api) {
            if ($this->api->successful()) {
                $apiJson = json_decode($this->api->body());
                $apiJson->response->editorConfig->mode = "view";

                return $this->document = json_encode($apiJson);
            }
        } elseif ($this->api) {
            return $this->document = $this->api->body();
        } else {
            return $this->api;
        }
    }

    private function checkIsLogin()
    {
        $onlyOfficeToken = OnlyOfficeTokens::where('user_id', auth()->id())->first();
        if ($onlyOfficeToken && $onlyOfficeToken->token) {
            if (Carbon::parse($onlyOfficeToken->expired_at)->isPast()) {
                $this->api = false;

                return $this->isLogin = false;
            } else {
                $res = $this->getDocService($onlyOfficeToken->token);
                $this->docService = json_decode($res)->response;

                return $this->fetchApi($this->id, $onlyOfficeToken->token);
            }
        } else {
            $this->api = false;

            return $this->isLogin = false;
        }
    }

    private function getDocService($token)
    {
        $res = Http::withHeaders(['Authorization' => $token])
                ->get($this->urlOnlyOffice."/api/2.0/files/docservice");

        return $res->body();
    }
}
