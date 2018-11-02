<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePlaylistsAddColumnsUserIdAndDeletedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('playlists', function(Blueprint $table)
        {
            $table->unsignedInteger('user_id')->after('name');
        });

        Schema::table('playlists', function(Blueprint $table)
        {
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('playlists', function(Blueprint $table)
        {
            $table->dropColumn('user_id');
        });


        Schema::table('playlists', function(Blueprint $table)
        {
            $table->dropColumn('deleted_at');
        });
    }
}
