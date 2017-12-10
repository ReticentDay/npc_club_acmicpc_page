<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatComprtitionInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprtitionInfo', function (Blueprint $table) {
            $table->increments('ComprtitionId');
            $table->string('UserName');
            $table->string('result')->nullable();
            $table->string('content')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('comprtitionList',function($table){
            $table->longText('content')->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comprtitionInfo');
        Schema::table('comprtitionList', function ($table) {
            $table->dropColumn('content');
        });
    }
}
