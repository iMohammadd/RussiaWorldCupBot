<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->foreign('team_one')
                ->references('id')
                ->on('teams')
                ->onUpdate('cascade');

            $table->foreign('team_two')
                ->references('id')->on('teams')
                ->onUpdate('cascade');
        });

        Schema::table('bets', function (Blueprint $table) {
            $table->foreign('profile_id')
                ->references('id')
                ->on('profiles')
                ->onUpdate('cascade');

            $table->foreign('match_id')
                ->references('id')
                ->on('matches')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->dropForeign('team_one');
            $table->dropForeign('team_two');
        });

        Schema::table('bets', function (Blueprint $table) {
            $table->dropForeign('profile_id');
            $table->dropForeign('match_id');
        });
    }
}
