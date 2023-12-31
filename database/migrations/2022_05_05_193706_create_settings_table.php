<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('display_name');
            $table->string('type');
            $table->string('key')->unique();
            $table->string('value')->nullable();
            $table->tinyInteger('multiple_values')->default(0);
            $table->string('details')->nullable();            
            $table->string('section')->default('general');
            $table->string('ordering')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
