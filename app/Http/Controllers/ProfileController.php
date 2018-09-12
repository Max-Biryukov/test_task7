<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{

    private $_rating = [
        5 => '5 звезд',
        4 => '4 звезды',
        3 => '3 звезды',
        2 => '2 звезды',
        1 => '1 звезда',
    ];

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        $user = \App\user::findOrFail( (int) $id );
        $authUser = \Auth::user();
        $rating = 0;

        if( $mark = $authUser->userRating($user->id)->first() ){
            $rating = $mark->pivot->rating;
        }

        return view( 'profile.show', [
            'user' => $user,
            'rating' => $this->_rating,
            'ratingForProfile' => $rating,
        ]);
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

    public function addComment( Request $request, $id )
    {
        $currentUser = \Auth::user();
        $profileId = (int) $id;
        if( $profileId > 0 && $profileId != $currentUser->id ){
            $currentUser->userComments()->attach([
                $profileId => [
                    'comment' => trim( strip_tags($request->comment) ),
                ]
            ]);

            \Session::flash( 'message', 'Комментарий добавлен' );
        }

        return redirect( route('profile.show', $id) );
    }

    public function addRating( Request $request, $id )
    {
        if(
            $request->has('rating') &&
            ( $rating = (int) $request->rating )&&
            $rating > 0 &&
            $rating <= 5
        ){

            $currentUser = \Auth::user();
            $profileId = (int) $id;
            if( $profileId > 0 && $profileId != $currentUser->id ){
                $currentUser->userRating()->sync([
                    $profileId => [
                        'rating' => $rating,
                    ]
                ]);
            }

            \Session::flash( 'message', 'Оценка добавлена' );
        }

        return redirect( route('profile.show', $id) );
    }

}
