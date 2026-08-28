<script setup>
import { onMounted } from 'vue'
import { useStrings } from '@/composables/useStrings'
import { useInformacaoIgreja } from '@/composables/useInformacaoIgreja'

const { strings } = useStrings()
const { informacaoIgreja, carregando, erro, carregar } = useInformacaoIgreja()

const NOME_IGREJA = 'Igreja Viva Foursquare'

// Ponto do Google Maps (https://maps.app.goo.gl/7GucD6VPi3Qwcs6SA), já com o
// pin da igreja selecionado — o CID vem do place_id resolvido desse link.
const MAPA_SRC = 'https://maps.google.com/maps?cid=9110119413147022634&output=embed'

onMounted(carregar)
</script>

<template>
  <section class="local" id="local">
    <div class="wrap local-grid">
      <div>
        <div class="eyebrow" v-reveal>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 21s7-6.1 7-11a7 7 0 1 0-14 0c0 4.9 7 11 7 11z" />
            <circle cx="12" cy="10" r="2.5" />
          </svg>
          {{ strings.localizacao.eyebrow }}
        </div>
        <h2 v-reveal style="font-size: clamp(26px, 3.2vw, 36px); color: var(--paper); margin-bottom: 8px">
          {{ strings.localizacao.titulo }}
        </h2>
        <p v-reveal style="color: var(--paper-dim); margin-bottom: 8px">
          {{ strings.localizacao.subtitulo }}
        </p>

        <p v-if="carregando" class="state-message">{{ strings.localizacao.carregando }}</p>
        <p v-else-if="erro" class="state-message state-message--erro">{{ strings.localizacao.erro }}</p>
        <template v-else-if="informacaoIgreja">
          <div class="info-row" v-reveal>
            <div class="ic">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M12 21s7-6.1 7-11a7 7 0 1 0-14 0c0 4.9 7 11 7 11z" />
                <circle cx="12" cy="10" r="2.5" />
              </svg>
            </div>
            <div>
              <h4>{{ strings.localizacao.enderecoTitulo }}</h4>
              <p>{{ informacaoIgreja.endereco }}</p>
            </div>
          </div>
          <div class="info-row" v-reveal>
            <div class="ic">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="12" cy="12" r="9" />
                <path d="M12 7v5l3 3" />
              </svg>
            </div>
            <div>
              <h4>{{ strings.localizacao.cultosTitulo }}</h4>
              <p>{{ informacaoIgreja.horario_cultos_resumo }}</p>
            </div>
          </div>
          <div class="info-row" v-reveal>
            <div class="ic">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path
                  d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.7A2 2 0 0 1 4.2 2h3a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.7a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.4-1.3a2 2 0 0 1 2.1-.5c.9.3 1.8.5 2.7.6a2 2 0 0 1 1.8 2z"
                />
              </svg>
            </div>
            <div>
              <h4>{{ strings.localizacao.contatoTitulo }}</h4>
              <p>{{ informacaoIgreja.telefone }} · {{ informacaoIgreja.email }}</p>
            </div>
          </div>
        </template>
      </div>
      <div class="map-frame" v-reveal>
        <iframe
          :src="MAPA_SRC"
          :title="`Mapa de localização — ${NOME_IGREJA}`"
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          allowfullscreen
        ></iframe>
      </div>
    </div>
  </section>
</template>
