<script setup>
import { onMounted } from 'vue'
import { useStrings } from '@/composables/useStrings'
import { useMinisterios } from '@/composables/useMinisterios'
import { ministerioIcones } from '@/config/ministerioIcones'

const { strings } = useStrings()
const { ministerios, carregando, erro, carregar } = useMinisterios()

onMounted(carregar)
</script>

<template>
  <section class="ministerios" id="ministerios">
    <div class="wrap">
      <div class="section-head" v-reveal>
        <div class="eyebrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path
              d="M12 21s-7-4.35-9.5-8.5C.8 8.9 2.7 5 6.5 5c2 0 3.5 1.2 4.5 2.6C12 6.2 13.5 5 15.5 5 19.3 5 21.2 8.9 19.5 12.5 17 16.65 12 21 12 21z"
            />
          </svg>
          {{ strings.ministerios.eyebrow }}
        </div>
        <h2>{{ strings.ministerios.titulo }}</h2>
        <p>{{ strings.ministerios.subtitulo }}</p>
      </div>

      <p v-if="carregando" class="state-message">{{ strings.ministerios.carregando }}</p>
      <p v-else-if="erro" class="state-message state-message--erro">{{ strings.ministerios.erro }}</p>
      <p v-else-if="ministerios.length === 0" class="state-message">{{ strings.ministerios.vazio }}</p>
      <div v-else class="min-grid" v-reveal>
        <div v-for="ministerio in ministerios" :key="ministerio.id" class="min-card">
          <div class="min-icon" v-html="ministerioIcones[ministerio.icone] ?? ministerioIcones.default"></div>
          <h3>{{ ministerio.nome }}</h3>
          <p>{{ ministerio.descricao }}</p>
        </div>
      </div>
    </div>
  </section>
</template>
