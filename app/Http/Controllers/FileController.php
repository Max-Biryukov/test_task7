<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\Psr7\mimetype_from_filename;
use App\Models\File;

class FileController extends Controller
{

    public function show( $id, $type = 'original' )
    {

    	$file = File::findOrFail( (int) $id );

        $path = join( DIRECTORY_SEPARATOR, [
            $file->id,
            $type . '_' . $file->filename
        ]);

    	$storage = \Storage::disk( 'files' );

    	if( $storage->has( $path ) ){

	        $headers[ 'Content-Type' ] = mimetype_from_filename( $file->filename );
	        return \Response::make( $storage->get( $path ), 200)->withHeaders( $headers );
    	}

		return '';
    }
}
