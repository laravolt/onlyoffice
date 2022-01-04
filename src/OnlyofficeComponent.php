<?php

namespace Laravolt\Onlyoffice;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;

class OnlyofficeComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     private int $id;
     public bool $readonly;
     public bool $isLogin = false;
     public string $uri_groupoffice;
     public string $uri_onlyoffice;
     public string $document = "";
     public $api;
    public function __construct($id, $readonly = false)
    {
        $this->id = $id;
        $this->readonly = $readonly;
        $this->uri_groupoffice = config()->get('services.onlyoffice.groupoffice_url');
        $this->uri_onlyoffice = config()->get('services.onlyoffice.onlyoffice_url');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $this->checkIsLogin();
        $this->isModeView($this->readonly);
        return view('onlyoffice::onlyoffice');
    }

    public function fetchApi($id, $token)
    {
        $res = Http::withHeaders(['Authorization' => $token])
                    ->get($this->uri_groupoffice."/api/2.0/files/file/$id/openedit");
        return $this->api = $res;
    }

    public function isModeView($mode)
    {
        if($mode && $this->api) {
            $apiJson = json_decode($this->api->body());
            $apiJson->response->editorConfig->mode = "view";
            return $this->document = json_encode($apiJson);
        } else if ($this->api) {
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
