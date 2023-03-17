<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePastesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pastes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('created_by_id');
            $table->foreign('created_by_id')->references('id')->on('users');
            $table->timestamp('expiration_time')->nullable();
            $table->string('access', 50);
            $table->string('hash', 16)->unique();
            $table->string('locale_lang', 10);
            $table->string('paste', 255);
            $table->softDeletes();
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
        Schema::dropIfExists('pastes');
    }
}
