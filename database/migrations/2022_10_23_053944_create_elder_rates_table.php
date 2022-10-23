<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elder_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('elder_info_id')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->enum('rating',[1,2,3,4,5]);
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
        Schema::dropIfExists('elder_rates');
    }
};
