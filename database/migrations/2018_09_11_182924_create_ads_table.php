<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments( 'id' );
            $table->unsignedInteger('picture_id' )
                  ->nullable();
            $table->unsignedInteger('user_id' )
                  ->nullable();
            $table->text('text' );
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('ads', function (Blueprint $table) {
            $table->foreign('picture_id' )
                  ->references( 'id' )
                  ->on( 'files' )
                  ->onDelete( 'SET NULL' )
                  ->onUpdate( 'SET NULL' )
            ;

            $table->foreign('user_id' )
                  ->references( 'id' )
                  ->on( 'users' )
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

        Schema::table('ads', function (Blueprint $table) {
            $table->dropForeign( ['picture_id', 'user_id'] );
        });

        Schema::dropIfExists('ads');
    }
}
