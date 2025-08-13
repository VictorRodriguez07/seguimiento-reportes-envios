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
        Schema::create('materiales_graficos', function (Blueprint $table) {
            $table->id();
            $table->string('img', 255);
            $table->string('nombre', 70);
            $table->int('cantidad')->default(0);
            $table->int('disponible')->default(0);
            $table->foreignId('tipo_material_grafico_id')
                ->constrained('tipo_material_graficos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiales_graficos');
    }
};
