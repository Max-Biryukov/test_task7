<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function avatar()
    {
        return $this->belongsTo( \App\Models\File::class );
    }

    /**
     * Комментарии, написанные текущим пользователем
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function userComments()
    {
        return $this->belongsToMany( \App\User::class, 'comments_users', 'author_id' )
                    ->withPivot('comment' )
                    ->withTimestamps();
    }

    /**
     * Комментарии, написанные к профилю текущего пользователя
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function profileComments()
    {
        return $this->belongsToMany( \App\User::class, 'comments_users', 'user_id', 'author_id' )
                    ->withPivot('comment' )
                    ->withTimestamps()
            ;
    }

    /**
     * Оценки, поставленные текущим пользователем
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function userRating( $id = null )
    {
        $result = $this->belongsToMany( \App\User::class, 'rating_users', 'author_id' )
                       ->withPivot('rating' )
                       ->withTimestamps();

        if( !empty($id) && $userId = (int) $id ){
            $result = $result->whereUserId( $userId );
        }

        return $result;
    }

    /**
     * Оценки, написанные к профилю текущего пользователя
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function profileRating()
    {
        return $this->belongsToMany( \App\User::class, 'rating_users', 'user_id', 'author_id' )
                    ->withPivot('rating' )
                    ->withTimestamps()
            ;
    }

}
