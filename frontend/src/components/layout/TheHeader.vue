<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useStrings } from '@/composables/useStrings'
import logoMark from '@/assets/images/logo-mark.png'

const { strings } = useStrings()

const scrolled = ref(false)

function aoRolar() {
  scrolled.value = window.scrollY > 20
}

onMounted(() => {
  window.addEventListener('scroll', aoRolar, { passive: true })
  aoRolar()
})

onUnmounted(() => {
  window.removeEventListener('scroll', aoRolar)
})
</script>

<template>
  <header id="siteHeader" :class="{ scrolled }">
    <div class="nav">
      <a class="brand" href="#">
        <img :src="logoMark" :alt="strings.footer.marca" />
      </a>
      <nav class="links">
        <a href="#sobre">{{ strings.nav.sobre }}</a>
        <a href="#cultos">{{ strings.nav.cultos }}</a>
        <a href="#ministerios">{{ strings.nav.ministerios }}</a>
        <a href="#local">{{ strings.nav.localizacao }}</a>
      </nav>
      <a class="nav-cta" href="#local">{{ strings.nav.cta }}</a>
    </div>
  </header>
</template>
