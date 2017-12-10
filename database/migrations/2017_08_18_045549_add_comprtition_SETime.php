<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddComprtitionSETime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprtitionList',function($table){
            $table->timestamp('start_time')->nullable()->after('content');
            $table->timestamp('end_time')->nullable()->after('content');
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
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
        });
    }
}
