<?php

namespace Laravolt\OnlyOffice\TableView;

use Laravolt\Ui\TableView;
use Illuminate\Support\Facades\Http;
use Laravolt\Suitable\Columns\Raw;
use Laravolt\Suitable\Columns\Text;

class TemplateTableView extends TableView
{
    public $folderId;
    public $token;

    public function data()
    {
        $res = Http::withHeaders(["Authorization" => $this->token])
                    ->get(config()->get('services.onlyoffice.groupoffice_url')."/api/2.0/files/$this->folderId");
        if ($res->successful()) {
            return json_decode($res->body())->response->files;
        } else {
            return [];
        }
    }

    public function columns(): array
    {
        return [
            Text::make('title', 'name'),
            Text::make('id', 'File Id'),
            Raw::make(function($file) {
                return '<a href="'.route('onlyoffice::template.edit', ['id' => $this->folderId, 'template' => $file->id]).'">Edit</a>
                <a href="'.route('onlyoffice::template.show', ['id' => $this->folderId, 'template' => $file->id]).'">Show</a>
                <a href="#" data-id="'.$file->id.'" class="link-delete">Delete</a>';
            }, 'Action')
        ];
    }
}
