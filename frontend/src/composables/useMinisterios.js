import { ref } from 'vue'
import { ministerioService } from '@/services/api/ministerioService'

export function useMinisterios() {
  const ministerios = ref([])
  const carregando = ref(false)
  const erro = ref(false)

  async function carregar() {
    carregando.value = true
    erro.value = false
    try {
      ministerios.value = await ministerioService.listar()
    } catch {
      erro.value = true
    } finally {
      carregando.value = false
    }
  }

  return { ministerios, carregando, erro, carregar }
}
