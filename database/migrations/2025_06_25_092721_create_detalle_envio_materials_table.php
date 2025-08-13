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
        Schema::create('detalle_envio_materials', function (Blueprint $table) {
            $table->id();
             $table->foreignId('id_material_grafico')
                ->constrained('materiales_graficos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('id_reporte_envio_evento')
                ->constrained('reporte_envios_eventos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('cantidad_enviada')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_envio_materials');
    }
};
