<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {

            $table->increments( 'id' );
            $table->string( 'filename', 55 );
            $table->string( 'realname' );
            $table->timestamps();

        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('avatar_id' )
                  ->references( 'id' )
                  ->on( 'files' )
                  ->onDelete( 'SET NULL' )
                  ->onUpdate( 'SET NULL' )
            ;
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign( ['avatar_id'] );
        });

        Schema::dropIfExists( 'files' );
    }
}
