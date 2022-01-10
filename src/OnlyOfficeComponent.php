<?php

namespace Laravolt\OnlyOffice;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\View\Component;

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
    public string $urlGroupOffice;
    public string $urlOnlyOffice;
    public string $document = "";
    public $api;

    public function __construct($id, $readonly = false)
    {
        $this->id = $id;
        $this->readOnly = $readonly;
        $this->urlGroupOffice = config()->get('services.onlyoffice.groupoffice_url');
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

    public function fetchApi($id, $token)
    {
        $res = Http::withHeaders(['Authorization' => $token])
                    ->get($this->urlGroupOffice."/api/2.0/files/file/$id/openedit");

        return $this->api = $res;
    }

    public function isModeView($mode)
    {
        if ($mode && $this->api) {
            $apiJson = json_decode($this->api->body());
            $apiJson->response->editorConfig->mode = "view";

            return $this->document = json_encode($apiJson);
        } elseif ($this->api) {
            return $this->document = $this->api->body();
        }
    }

    private function checkIsLogin()
    {
        $login = Cookie::get('isLogin');
        if ($login) {
            $this->fetchApi($this->id, $login);

            return $this->isLogin = true;
        } else {
            $this->api = false;

            return $this->isLogin = false;
        }
    }
}
