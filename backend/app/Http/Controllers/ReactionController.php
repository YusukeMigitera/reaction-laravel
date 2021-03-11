<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAsset;
use Illuminate\Support\Facades\Storage;

class ReactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Reaction::latest()->paginate();
    }

    public function page_index()
    {
        //
        return view('welcome', ['data' => $this->index()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return Reaction::create($request->all());
    }

    public function page_confirm(Request $request)
    {
        //
        $this->validate($request, [
            //input nameのhydride
            'hydride' => [
                // 必須
                'required',
                // アップロードされたファイルであること
                'file',
                // 画像ファイルであること
                'image',
                // MIMEタイプを指定
                'mimes:jpeg,png',
            ]
        ]);

        if ($request->file('hydride')->isValid([])) {
            $disk = Storage::disk('s3');
            $disk->put('/', $request->file('hydride'), 'public');
            $filename = $request->file('hydride')->getClientOriginalName();
            $list = $disk->files('/');
            $path = $disk->url('/'.$list[0]);
//            $path = $request->hydride->store('assets', 's3');
//            if (!$path) {
//                abort(500);
//            }
            $data = [
                'material'  => $request->material,
                'substrate'  => $request->substrate,
                'metal'  => $request->metal,
                'ligand'  => $request->ligand,
                'hydride'  => $path,
                'base'  => $request->base,
                'solvent'  => $request->solvent,
                'temperature'  => $request->temperature,
                'time'  => $request->time,
                'yield'  => $request->yield,
                'remarks'  => $request->remarks,
            ];
            return view('confirm', $data);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors();
        }
    }

    public function download(Reaction $reaction)
    {
        return Storage::disk('s3')->download($reaction->hydride);
    }

    public function page_store(Request $request)
    {
        //
        $reaction = new Reaction;
        $reaction->material = $request->material;
        $reaction->substrate = $request->substrate;
        $reaction->metal = $request->metal;
        $reaction->ligand = $request->ligand;
        $reaction->hydride = $request->hydride;
        $reaction->base = $request->base;
        $reaction->solvent = $request->solvent;
        $reaction->temperature = $request->temperature;
        $reaction->time = $request->time;
        $reaction->yield = $request->yield;
        $reaction->remarks = $request->remarks;
        $reaction->save();
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reaction  $reaction
     * @return \Illuminate\Http\Response
     */
    public function show(Reaction $reaction)
    {
        //
        return $reaction;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reaction  $reaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Reaction $reaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reaction  $reaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reaction $reaction)
    {
        //
        $reaction->update($request->all());
        return $reaction;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reaction  $reaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reaction $reaction)
    {
        //
        $deleted = $reaction->delete();
        return compact('deleted');
    }
}
