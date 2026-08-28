<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitacoes_visita', function (Blueprint $table): void {
            $table->id();
            $table->string('nome', 120);
            $table->string('telefone', 20);
            $table->string('email', 120);
            $table->foreignId('culto_id')->nullable()->constrained('cultos')->nullOnDelete();
            $table->string('mensagem', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitacoes_visita');
    }
};
