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
        Schema::create('butterfly_vk', function (Blueprint $table) {
            $table->id(); // Автоматическое поле ID
            $table->string('name'); // Поле для имени
            $table->string('message', 500)->nullable(); // Сообщение (максимум 500 символов)
            $table->timestamps(); // Поля created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('butterfly_vk');
    }
};
