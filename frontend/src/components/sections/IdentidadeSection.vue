<script setup>
import { useStrings } from '@/composables/useStrings'

const { strings } = useStrings()
</script>

<template>
  <section class="identidade" id="identidade">
    <div class="wrap">
      <div class="section-head" v-reveal>
        <div class="eyebrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path
              d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8L12 21l8.8-8.6a5.5 5.5 0 0 0 0-7.8z"
            />
          </svg>
          {{ strings.identidade.eyebrow }}
        </div>
        <h2>{{ strings.identidade.titulo }}</h2>
        <p>{{ strings.identidade.subtitulo }}</p>
      </div>

      <div class="identidade-grid" v-reveal>
        <div v-for="item in strings.identidade.itens" :key="item.tag" class="identidade-card">
          <span class="tag">{{ item.tag }}</span>
          <p v-html="item.texto"></p>
          <div v-if="item.chips" class="identidade-chips">
            <span v-for="chip in item.chips" :key="chip">{{ chip }}</span>
          </div>
        </div>
      </div>

      <div class="identidade-destaque" v-reveal>
        <div class="icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18V5l12-2v13" />
            <circle cx="6" cy="18" r="3" />
            <circle cx="18" cy="16" r="3" />
          </svg>
        </div>
        <div>
          <span class="tag">{{ strings.identidade.cultura.tag }}</span>
          <p v-html="strings.identidade.cultura.texto"></p>
        </div>
      </div>
    </div>
  </section>
</template>
