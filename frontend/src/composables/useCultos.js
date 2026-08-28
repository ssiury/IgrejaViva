import { ref } from 'vue'
import { cultoService } from '@/services/api/cultoService'

export function useCultos() {
  const cultos = ref([])
  const carregando = ref(false)
  const erro = ref(false)

  async function carregar() {
    carregando.value = true
    erro.value = false
    try {
      cultos.value = await cultoService.listar()
    } catch {
      erro.value = true
    } finally {
      carregando.value = false
    }
  }

  return { cultos, carregando, erro, carregar }
}
