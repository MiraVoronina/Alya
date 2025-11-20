<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBreedCategoryToPetsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->string('breed_category', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn('breed_category');
        });
    }
}
