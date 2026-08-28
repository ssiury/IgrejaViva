import { ref } from 'vue'
import { informacaoIgrejaService } from '@/services/api/informacaoIgrejaService'

export function useInformacaoIgreja() {
  const informacaoIgreja = ref(null)
  const carregando = ref(false)
  const erro = ref(false)

  async function carregar() {
    carregando.value = true
    erro.value = false
    try {
      informacaoIgreja.value = await informacaoIgrejaService.obter()
    } catch {
      erro.value = true
    } finally {
      carregando.value = false
    }
  }

  return { informacaoIgreja, carregando, erro, carregar }
}
