<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id');
            $table->foreignId('user_id');
            $table->date('rent_start_date');
            $table->date('rent_end_date');
            $table->enum('status', ['ACTIVE', 'RETURNED'])->default('ACTIVE');
            $table->decimal('total_rent_fee', 20, 2);
            $table->date('date_of_return')->nullable();
            $table->decimal('late_fee', 20, 2)->nullable();
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
        Schema::dropIfExists('rents');
    }
}
