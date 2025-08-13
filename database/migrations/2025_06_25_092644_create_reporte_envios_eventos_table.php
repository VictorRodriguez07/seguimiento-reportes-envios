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
        Schema::create('reporte_envio_evento', function (Blueprint $table) {
            $table->id();
            $table>date('fecha_envio');
            $table->string('nombre_evento', 60);
            $table->string('direccion_entrega', 255)->nullable();
            $table->text('observaciones')->nullable();
            $table->foreignId('id_destinatario')
                ->constrained('User')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('id_responsable')
                ->constrained('User')
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
        Schema::dropIfExists('reporte_envios_eventos');
    }
};
