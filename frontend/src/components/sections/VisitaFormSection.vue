<script setup>
import { onMounted, reactive } from 'vue'
import { useStrings } from '@/composables/useStrings'
import { useCultos } from '@/composables/useCultos'
import { useSolicitacaoVisita } from '@/composables/useSolicitacaoVisita'

const { strings } = useStrings()
const { cultos, carregar: carregarCultos } = useCultos()
const { enviando, enviada, mensagemErro, errosPorCampo, enviar } = useSolicitacaoVisita()

onMounted(carregarCultos)

const form = reactive({
  nome: '',
  telefone: '',
  email: '',
  culto_id: '',
  mensagem: '',
})

async function aoSubmeter() {
  await enviar({
    ...form,
    culto_id: form.culto_id || null,
  })

  if (enviada.value) {
    form.nome = ''
    form.telefone = ''
    form.email = ''
    form.culto_id = ''
    form.mensagem = ''
  }
}
</script>

<template>
  <section class="visita-form" id="quero-visitar">
    <div class="wrap">
      <div class="section-head" v-reveal>
        <div class="eyebrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path
              d="M12 21s7-6.1 7-11a7 7 0 1 0-14 0c0 4.9 7 11 7 11z"
            />
            <circle cx="12" cy="10" r="2.5" />
          </svg>
          {{ strings.visitaForm.eyebrow }}
        </div>
        <h2>{{ strings.visitaForm.titulo }}</h2>
        <p>{{ strings.visitaForm.subtitulo }}</p>
      </div>

      <form class="form-grid" v-reveal @submit.prevent="aoSubmeter">
        <div class="form-field full">
          <label for="visita-nome">{{ strings.visitaForm.campoNome }}</label>
          <input
            id="visita-nome"
            v-model="form.nome"
            type="text"
            required
            maxlength="120"
            :placeholder="strings.visitaForm.campoNomePlaceholder"
          />
          <span v-if="errosPorCampo.nome" class="campo-erro">{{ errosPorCampo.nome[0] }}</span>
        </div>

        <div class="form-field">
          <label for="visita-telefone">{{ strings.visitaForm.campoTelefone }}</label>
          <input
            id="visita-telefone"
            v-model="form.telefone"
            type="tel"
            required
            :placeholder="strings.visitaForm.campoTelefonePlaceholder"
          />
          <span v-if="errosPorCampo.telefone" class="campo-erro">{{ errosPorCampo.telefone[0] }}</span>
        </div>

        <div class="form-field">
          <label for="visita-email">{{ strings.visitaForm.campoEmail }}</label>
          <input
            id="visita-email"
            v-model="form.email"
            type="email"
            required
            :placeholder="strings.visitaForm.campoEmailPlaceholder"
          />
          <span v-if="errosPorCampo.email" class="campo-erro">{{ errosPorCampo.email[0] }}</span>
        </div>

        <div class="form-field full">
          <label for="visita-culto">{{ strings.visitaForm.campoCulto }}</label>
          <select id="visita-culto" v-model="form.culto_id">
            <option value="">{{ strings.visitaForm.campoCultoPlaceholder }}</option>
            <option v-for="culto in cultos" :key="culto.id" :value="culto.id">
              {{ culto.titulo }} · {{ culto.horario }}
            </option>
          </select>
          <span v-if="errosPorCampo.culto_id" class="campo-erro">{{ errosPorCampo.culto_id[0] }}</span>
        </div>

        <div class="form-field full">
          <label for="visita-mensagem">{{ strings.visitaForm.campoMensagem }}</label>
          <textarea
            id="visita-mensagem"
            v-model="form.mensagem"
            maxlength="500"
            :placeholder="strings.visitaForm.campoMensagemPlaceholder"
          ></textarea>
          <span v-if="errosPorCampo.mensagem" class="campo-erro">{{ errosPorCampo.mensagem[0] }}</span>
        </div>

        <div class="form-field full form-actions">
          <button class="btn-primary" type="submit" :disabled="enviando">
            {{ enviando ? strings.visitaForm.botaoEnviando : strings.visitaForm.botaoEnviar }}
          </button>
        </div>
      </form>

      <p v-if="enviada" class="form-message form-message--sucesso">{{ strings.visitaForm.sucesso }}</p>
      <p v-else-if="mensagemErro" class="form-message form-message--erro">{{ mensagemErro }}</p>
      <p v-else-if="Object.keys(errosPorCampo).length > 0" class="form-message form-message--erro">
        {{ strings.visitaForm.erroValidacao }}
      </p>
    </div>
  </section>
</template>
