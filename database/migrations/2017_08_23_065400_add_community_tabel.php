<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommunityTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communitytabel', function (Blueprint $table) {
            $table->increments('id');
            $table->string('creat_user');
            $table->string('type')->default('other');
            $table->string('association')->nullable();
            $table->string('title');
            $table->longText('content');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('communitygood', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name');
            $table->integer('community_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communitytabel');
        Schema::dropIfExists('communitygood');
    }
}
