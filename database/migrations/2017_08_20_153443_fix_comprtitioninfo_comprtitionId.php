<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixComprtitioninfoComprtitionId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('comprtitionInfo');
        Schema::create('comprtitionInfo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ComprtitionId');
            $table->string('UserName');
            $table->string('result')->nullable();
            $table->string('content')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('comprtitionList',function($table){
            $table->boolean('Settlement')->default(0)->after('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comprtitionList', function ($table) {
            $table->dropColumn('Settlement');
        });
    }
}
