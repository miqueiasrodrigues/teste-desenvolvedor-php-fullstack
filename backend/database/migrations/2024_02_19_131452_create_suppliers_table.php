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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('identification')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('street');
            $table->string('number')->default("S/N");
            $table->string('neighborhood');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('complement')->default("");
            $table->string('situation')->default("");
            $table->date('situation_date');
            $table->string('type');
            $table->string('legal_nature');
            $table->string('situation_reason')->default("");
            $table->date('opening_date');
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
        Schema::dropIfExists('suppliers');
    }
};
