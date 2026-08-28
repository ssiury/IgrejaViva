<script setup>
import { useStrings } from '@/composables/useStrings'
import footerBadge from '@/assets/images/footer-badge.jpg'

const { strings } = useStrings()
</script>

<template>
  <footer>
    <div class="wrap">
      <div class="footer-top">
        <div class="footer-brand">
          <img :src="footerBadge" :alt="strings.footer.marca" />
          <span>{{ strings.footer.marca }}</span>
        </div>
        <div class="footer-social">
          <a
            href="https://www.instagram.com/igrejaviva.foursquare/"
            target="_blank"
            rel="noopener noreferrer"
            :aria-label="strings.footer.redeInstagram"
          >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <rect x="3" y="3" width="18" height="18" rx="5" />
              <circle cx="12" cy="12" r="4" />
              <circle cx="17.5" cy="6.5" r="1" />
            </svg>
          </a>
          <a
            href="https://www.youtube.com/@quadrangular.jdbrasil8816"
            target="_blank"
            rel="noopener noreferrer"
            :aria-label="strings.footer.redeYoutube"
          >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <rect x="2" y="5" width="20" height="14" rx="4" />
              <path d="M10 9.5v5l5-2.5z" fill="currentColor" stroke="none" />
            </svg>
          </a>
          <a
            href="https://wa.me/556291876700"
            target="_blank"
            rel="noopener noreferrer"
            :aria-label="strings.footer.redeWhatsapp"
          >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path
                d="M21 11.5a8.4 8.4 0 0 1-12.3 7.4L3 20l1.2-5.5A8.4 8.4 0 1 1 21 11.5z"
              />
            </svg>
          </a>
        </div>
      </div>
      <div class="footer-bottom">
        <span>{{ strings.footer.copyright }}</span>
        <span>{{ strings.footer.tagline }}</span>
      </div>
    </div>
  </footer>
</template>
