<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\Psr7\mimetype_from_filename;

class FileController extends Controller
{

    public function show( $id, $type = 'original' )
    {

    	$file = \App\Models\File::findOrFail( (int) $id );

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

    public static function saveFile( $fileData )
    {
        if( !empty($fileData) ){
            $newFileName = str_random( 45 );
            $originalFileName = $fileData->getClientOriginalName();
            $extention = substr( $originalFileName, strrpos($originalFileName, '.') );

            $file = \App\Models\File::create([
                'filename' => $newFileName . $extention,
                'realname' => $originalFileName,
            ]);

            if (!empty($file->id)) {

                $photo = \File::get( $fileData );
                $smallfile = \Image::make( $photo )->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $mediumFile = \Image::make( $photo )->resize(250, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                \Storage::disk('files')->put( $file->id . DIRECTORY_SEPARATOR . 'original_' . $newFileName . $extention, $photo );
                \Storage::disk('files')->put( $file->id . DIRECTORY_SEPARATOR . 'small_' . $newFileName . $extention, $smallfile->stream() );
                \Storage::disk('files')->put( $file->id . DIRECTORY_SEPARATOR . 'medium_' . $newFileName . $extention, $mediumFile->stream() );
            }
        }

        return !empty( $file ) ? $file->id : null;

    }
}
