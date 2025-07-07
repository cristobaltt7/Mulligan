<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('decks', function (Blueprint $table) {
            $table->id(); //Necesario para el ORM Eloquent
            $table->string('name', 30);
            $table->text('description')->nullable();
            $table->string('commander', 50);
            $table->text('decklist')->nullable();
            $table->string('owner_name', 30);
            /*Dueño del mazo (relación 1-N, dado que un usuario puede tener múltiples mazos)*/
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('users');
            $table->timestamps(); //Necesario para el ORM Eloquent
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('decks');
    }
};
