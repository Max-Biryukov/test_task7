<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        dd('12');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        return view( 'profile.edit', [
            'user' => \Auth::user()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id )
    {

        $messages = [
            'name.required' => 'Имя обязательно для заполнения',
            'avatar.image' => 'Аватар должен быть картинкой',
        ];

        $request->validate([
            'name' => 'required',
            'avatar' => 'sometimes|image',
        ], $messages);

        $fileData = $request->has( 'avatar' ) ? $request->file('avatar' ) : [] ;
        $fileId = FileController::saveFile( $fileData );

        $user = \Auth::user();
        $user->name = trim( strip_tags($request->name) );
        $user->about = trim( strip_tags($request->about) );

        if( !empty($fileId) ){

            if( !empty($user->avatar_id) ){
                \Storage::disk( 'files' )->deleteDirectory( $user->avatar_id );
                $user->avatar->delete();
            }

            $user->avatar_id = $fileId;
        }

        if( $user->save() ){
            \Session::flash( 'message', 'Профиль обновлен' );
        }

        return redirect( route('profile.edit', $user->id) );
    }

}
