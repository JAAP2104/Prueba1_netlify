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
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table -> unsignedBigInteger('id_tipos_de_solicitudes');
            $table->timestamp('fecha_y_hora_de_la_solicitud');
            $table -> unsignedBigInteger('id_usuario_que_realiza_la_solicitud');
            $table -> unsignedBigInteger('id_eventos_especiales_por_categorias');
            $table -> unsignedBigInteger('id_estado_de_la_solicitud');
            $table -> foreign('id_tipos_de_solicitudes')->references('id')-> on ('tipos_de_solicitudes');
            $table -> foreign('id_usuario_que_realiza_la_solicitud')->references('id')-> on ('users');
            $table -> foreign('id_eventos_especiales_por_categorias')->references('id')-> on ('eventos_especiales_por_categorias');
            $table -> foreign('id_estado_de_la_solicitud')->references('id')-> on ('estados_de_las_solictudes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
