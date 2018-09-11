<?php

namespace App\Models;

use function GuzzleHttp\Psr7\mimetype_from_filename;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'filename',
        'realname',
    ];

    public function getPath( $type = 'original' )
    {



        $path = join( DIRECTORY_SEPARATOR, [
            $this->id,
            $type . '_' . $this->filename
        ]);

    	if( \Storage::disk( 'files' )->has( $path ) ){
	        $headers[ 'Content-Type' ] = mimetype_from_filename( $this->filename );
	        return \Response::make( \Storage::disk( 'files' )->get( $path ), 200)->withHeaders( $headers );
    	}

    	return '';
    }

}
