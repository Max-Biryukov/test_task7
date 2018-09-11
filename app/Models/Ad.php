<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model
{
    use SoftDeletes;
    protected $table = 'ads';

    protected $fillable = [
        'picture_id',
        'user_id',
        'text',
    ];

    protected $dates = [ 'deleted_at' ];

    public function user()
    {
        return $this->belongsTo( \App\User::class );
    }
}
