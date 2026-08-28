<?php

namespace App\Modules\SolicitacaoVisita\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitacaoVisitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:120'],
            'telefone' => ['required', 'string', 'regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/'],
            'email' => ['required', 'email'],
            'culto_id' => ['nullable', 'integer', 'exists:cultos,id'],
            'mensagem' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nome' => __('solicitacao_visita.atributos.nome'),
            'telefone' => __('solicitacao_visita.atributos.telefone'),
            'email' => __('solicitacao_visita.atributos.email'),
            'culto_id' => __('solicitacao_visita.atributos.culto_id'),
            'mensagem' => __('solicitacao_visita.atributos.mensagem'),
        ];
    }
}
