<script setup>
import { ref } from 'vue'
import { useStrings } from '@/composables/useStrings'
import { useEmberParticles } from '@/composables/useEmberParticles'
import logoMark from '@/assets/images/logo-mark.png'

const { strings } = useStrings()

const embersCanvas = ref(null)
useEmberParticles(embersCanvas)
</script>

<template>
  <section class="hero">
    <canvas id="embers" ref="embersCanvas"></canvas>
    <div class="wrap hero-inner">
      <div>
        <div class="eyebrow">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path
              d="M12 2c2 4-2 5-2 8a3 3 0 0 0 6 0c0-1-.5-2-1-3 1 0 3 2 3 5a6 6 0 0 1-12 0c0-4 3-5 3-7 0-1-.5-2-1-3 1 0 3 0 4 0z"
            />
          </svg>
          {{ strings.hero.eyebrow }}
        </div>
        <h1>
          {{ strings.hero.tituloPrefixo1 }} <em>{{ strings.hero.tituloDestaque1 }}</em
          ><br />
          {{ strings.hero.tituloPrefixo2 }} <em>{{ strings.hero.tituloDestaque2 }}</em>
        </h1>
        <p class="lead">{{ strings.hero.lead }}</p>
        <div class="hero-ctas">
          <a class="btn-primary" href="#cultos">{{ strings.hero.ctaPrimario }}</a>
          <a class="btn-ghost" href="#local">{{ strings.hero.ctaSecundario }}</a>
        </div>
      </div>
      <div class="hero-mark">
        <div class="glow"></div>
        <img :src="logoMark" alt="" />
      </div>
    </div>
    <div class="scroll-cue">
      <span>{{ strings.hero.scrollCue }}</span>
      <div class="line"></div>
    </div>
  </section>

  <div class="flame-divider">
    <svg viewBox="0 0 120 34" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
        d="M60 2c6 6-4 8-4 14a8 8 0 0 0 16 0c0-3-1.5-5-3-7 3 0 8 5 8 12a13 13 0 1 1-26 0c0-9 7-11 7-16 0-2-1-4-2-5 2 0 4 1 4 2z"
        stroke="url(#g1)"
        stroke-width="1.4"
      />
      <defs>
        <linearGradient id="g1" x1="0" y1="0" x2="0" y2="1">
          <stop stop-color="#ffcf4d" />
          <stop offset="1" stop-color="#c2360c" />
        </linearGradient>
      </defs>
    </svg>
  </div>
</template>
