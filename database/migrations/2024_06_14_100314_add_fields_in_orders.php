<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('contact_name')->nullable();
            $table->text('contact_number')->nullable();
            $table->text('area_zone')->nullable();
            $table->text('local_area_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('contact_name');
            $table->dropColumn('contact_number');
            $table->dropColumn('area_zone');
            $table->dropColumn('local_area_id');
        });
    }
}
