<?php

namespace Laravolt\OnlyOffice\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Laravolt\OnlyOffice\Models\OnlyOfficeTokens;

class TemplateController extends Controller
{
    private string $token;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->token = OnlyOfficeTokens::where('user_id', auth()->id())->first()->token;

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $token = $this->token;

        return view('onlyoffice::templates.index', compact('id', 'token'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('onlyoffice::templates.create', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'file.*' => 'required|mimes:doc,docx',
        ]);

        $res = Http::withHeaders(["Authorization" => $this->token])
                    ->attach('file', file_get_contents($request->file), $request->file->getClientOriginalName())
                    ->post(config()->get('services.onlyoffice.onlyoffice_url')."/api/2.0/files/$id/upload");
        if ($res->successful()) {
            return redirect()->to(route('onlyoffice::template.index', $id))->withSuccess('Berhasil upload templates');
        } else {
            return redirect()->back()->withErrors('Gagal upload templates');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $template)
    {
        $open = "show";

        return view('onlyoffice::templates.open', compact('id', 'template', 'open'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $template)
    {
        $open = "edit";

        return view('onlyoffice::templates.open', compact('id', 'template', 'open'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $template)
    {
        $res = Http::withHeaders(["Authorization" => $this->token])
                            ->delete(config()->get('services.onlyoffice.onlyoffice_url')."/api/2.0/files/file/$template");
        if ($res->successful()) {
            return redirect()->back()->withSuccess('Berhasil menghapus file');
        } else {
            return redirect()->back()->withErrors('Gagal menghapus file');
        }
    }
}
