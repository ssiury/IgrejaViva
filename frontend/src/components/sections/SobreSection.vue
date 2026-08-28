<script setup>
import { useStrings } from '@/composables/useStrings'
import logoMark from '@/assets/images/logo-mark.png'

const { strings } = useStrings()
</script>

<template>
  <section class="sobre" id="sobre">
    <div class="wrap sobre-grid">
      <div class="sobre-visual" v-reveal>
        <img :src="logoMark" alt="" />
      </div>
      <div class="sobre-copy">
        <div class="eyebrow" v-reveal>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="9" />
          </svg>
          {{ strings.sobre.eyebrow }}
        </div>
        <h2 v-reveal style="font-size: clamp(26px, 3.2vw, 36px); color: var(--paper); margin-bottom: 22px">
          {{ strings.sobre.titulo }}
        </h2>
        <p v-reveal>{{ strings.sobre.paragrafo1 }}</p>
        <p v-reveal>{{ strings.sobre.paragrafo2 }}</p>
        <div class="verse" v-reveal>{{ strings.sobre.versiculo }}</div>
        <div class="verse-ref" v-reveal>{{ strings.sobre.versiculoReferencia }}</div>
      </div>
    </div>
  </section>
</template>
