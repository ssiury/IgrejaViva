<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informacoes_igreja', function (Blueprint $table): void {
            $table->id();
            $table->string('endereco', 200);
            $table->string('telefone', 30);
            $table->string('email', 120);
            $table->string('horario_cultos_resumo', 150);
            $table->string('instagram_url', 200)->nullable();
            $table->string('youtube_url', 200)->nullable();
            $table->string('whatsapp_url', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informacoes_igreja');
    }
};
