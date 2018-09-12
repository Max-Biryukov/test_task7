<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Http\Controllers\FileController;

class AdController extends Controller
{

    const ADS_PER_PAGE = 20;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view( 'ad.index',[
            'ads' => Ad::orderBy( 'id', 'desc' )->paginate( self::ADS_PER_PAGE )
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

}
