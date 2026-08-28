<script setup>
import { onMounted } from 'vue'
import { useStrings } from '@/composables/useStrings'
import { useCultos } from '@/composables/useCultos'

const { strings } = useStrings()
const { cultos, carregando, erro, carregar } = useCultos()

onMounted(carregar)
</script>

<template>
  <section id="cultos">
    <div class="wrap">
      <div class="section-head" v-reveal>
        <div class="eyebrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="9" />
            <path d="M12 7v5l3 3" />
          </svg>
          {{ strings.cultos.eyebrow }}
        </div>
        <h2>{{ strings.cultos.titulo }}</h2>
        <p>{{ strings.cultos.subtitulo }}</p>
      </div>

      <p v-if="carregando" class="state-message">{{ strings.cultos.carregando }}</p>
      <p v-else-if="erro" class="state-message state-message--erro">{{ strings.cultos.erro }}</p>
      <p v-else-if="cultos.length === 0" class="state-message">{{ strings.cultos.vazio }}</p>
      <div v-else class="cultos-grid" v-reveal>
        <div v-for="culto in cultos" :key="culto.id" class="culto-card">
          <span class="tag">{{ culto.tag }}</span>
          <h3>{{ culto.titulo }}</h3>
          <div class="time">{{ culto.horario }}</div>
          <p>{{ culto.descricao }}</p>
        </div>
      </div>
    </div>
  </section>
</template>
