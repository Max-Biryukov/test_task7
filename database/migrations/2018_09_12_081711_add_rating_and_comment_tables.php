<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRatingAndCommentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments_users', function (Blueprint $table) {
            $table->unsignedInteger('author_id' )
                  ->comment( 'Кто пишет комментарий' )
                  ->nullable();
            $table->unsignedInteger('user_id' )
                  ->comment( 'Кому пишут комментарий' )
                  ->nullable();
            $table->text( 'comment' );
            $table->timestamps();

        });


        Schema::table('comments_users', function (Blueprint $table) {
            $table->foreign('author_id' )
                  ->references( 'id' )
                  ->on( 'users' )
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

        Schema::create('rating_users', function (Blueprint $table) {
            $table->unsignedInteger('author_id' )
                  ->comment( 'Кто ставит оценку' )
                  ->nullable();
            $table->unsignedInteger('user_id' )
                  ->comment( 'Кому ставят оценку' )
                  ->nullable();
            $table->unsignedTinyInteger( 'rating' );
            $table->timestamps();

        });


        Schema::table('rating_users', function (Blueprint $table) {
            $table->foreign('author_id' )
                  ->references( 'id' )
                  ->on( 'users' )
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
        Schema::table('comments_users', function (Blueprint $table) {
            $table->dropForeign( ['author_id'] );
            $table->dropForeign( ['user_id'] );
        });

        Schema::dropIfExists('comments_users');
    }
}
