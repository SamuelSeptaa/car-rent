<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSideBarMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('side_bar_menus', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('uri')->nullable();
            $table->string('icon')->nullable();
            $table->string('permission_name')->nullable();
            $table->string('header')->nullable();
            $table->enum('is_has_data_manipulation', ['YES', 'NO'])->default('NO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('side_bar_menus');
    }
}
