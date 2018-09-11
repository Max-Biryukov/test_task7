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

        if( !empty($fileData) ){

            $newFileName = str_random( 45 );
            $originalFileName = $fileData->getClientOriginalName();
            $extention = substr( $originalFileName, strrpos($originalFileName, '.') );

            $avatar = \App\Models\File::create([
                'filename' => $newFileName . $extention,
                'realname' => $originalFileName,
            ]);

            if( !empty($avatar->id) ){

                $photo = \File::get( $fileData );
                $smallfile = \Image::make( $photo )->resize( 100, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $mediumFile = \Image::make( $photo )->resize( 250, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                \Storage::disk( 'files' )->put( $avatar->id . DIRECTORY_SEPARATOR . 'original_' . $newFileName . $extention, $photo );
                \Storage::disk( 'files' )->put( $avatar->id . DIRECTORY_SEPARATOR . 'small_' . $newFileName . $extention, $smallfile->stream() );
                \Storage::disk( 'files' )->put( $avatar->id . DIRECTORY_SEPARATOR . 'medium_' . $newFileName . $extention, $mediumFile->stream() );
            }
        }

        $user = \Auth::user();
        $user->name = trim( strip_tags($request->name) );
        $user->about = trim( strip_tags($request->about) );

        if( !empty($avatar->id) ){

            if( !empty($user->avatar_id) ){
                \Storage::disk( 'files' )->deleteDirectory( $user->avatar_id );
                $user->avatar->delete();
            }

            $user->avatar_id = $avatar->id;
        }

        if( $user->save() ){
            \Session::flash( 'message', 'Профиль обновлен' );
        }

        return redirect( route('profile.edit', $user->id) );
    }

}
