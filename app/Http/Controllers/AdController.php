<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Http\Controllers\FileController;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view( 'ad.index',[
            'ads' => Ad::paginate( 2 )
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( 'ad.edit' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request )
    {
        $messages = [
            'text.required' => 'Заполните текст объявления',
            'picture.image' => 'Аватар должен быть картинкой',
        ];

        $request->validate([
            'text' => 'required',
            'picture' => 'sometimes|image',
        ], $messages);

        $fileData = $request->has( 'picture' ) ? $request->file('picture' ) : [] ;
        $fileId = FileController::saveFile( $fileData );

        $ad = Ad::create([
            'user_id' => \Auth::user()->id,
            'picture_id' => $fileId,
            'text' => trim( strip_tags($request->text) )
        ]);

        if( !empty($ad->id) ){
            \Session::flash( 'message', 'Объявление успешно создано' );
        }

        return redirect( route('main_page') );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
