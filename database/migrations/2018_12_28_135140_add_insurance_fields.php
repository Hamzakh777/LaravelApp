<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInsuranceFields extends Migration
{
    /**
     * The igration class representes the blueprint for a table
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table is to update the table
        // Schema::create will create the table
        Schema::table('posts', function ($table) {
            //company name
            $table->string('c_name');
            //compqny website
            $table->string('c_web');
            // company facts
            $table->text('facts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function ($table) {
            //company name
            $table->dropColumn('c_name');
            //compqny website
            $table->dropColumn('c_web');
            // company rating
            $table->dropColumn('facts');
        });
    }
}
