<script setup>
import { useStrings } from '@/composables/useStrings'
import TheHeader from '@/components/layout/TheHeader.vue'
import TheFooter from '@/components/layout/TheFooter.vue'
import HeroSection from '@/components/sections/HeroSection.vue'
import SobreSection from '@/components/sections/SobreSection.vue'
import IdentidadeSection from '@/components/sections/IdentidadeSection.vue'
import CultosSection from '@/components/sections/CultosSection.vue'
import MinisteriosSection from '@/components/sections/MinisteriosSection.vue'
import LocalizacaoSection from '@/components/sections/LocalizacaoSection.vue'

const { strings } = useStrings()
</script>

<template>
  <TheHeader />

  <main>
    <HeroSection />
    <SobreSection />
    <IdentidadeSection />
    <CultosSection />
    <MinisteriosSection />

    <section class="cta-band">
      <div class="wrap" v-reveal>
        <h2>{{ strings.ctaBand.titulo }}</h2>
        <p>{{ strings.ctaBand.subtitulo }}</p>
        <a class="btn-primary" href="#local">{{ strings.ctaBand.cta }}</a>
      </div>
    </section>

    <LocalizacaoSection />
  </main>

  <TheFooter />
</template>
