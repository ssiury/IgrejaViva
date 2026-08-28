import { ref } from 'vue'
import { solicitacaoVisitaService } from '@/services/api/solicitacaoVisitaService'

export function useSolicitacaoVisita() {
  const enviando = ref(false)
  const enviada = ref(false)
  const mensagemErro = ref(null)
  const errosPorCampo = ref({})

  async function enviar(dados) {
    enviando.value = true
    enviada.value = false
    mensagemErro.value = null
    errosPorCampo.value = {}

    try {
      await solicitacaoVisitaService.criar(dados)
      enviada.value = true
    } catch (excecao) {
      const resposta = excecao.response?.data
      errosPorCampo.value = resposta?.errors ?? {}
      mensagemErro.value = resposta?.mensagem ?? resposta?.message ?? null
    } finally {
      enviando.value = false
    }
  }

  return { enviando, enviada, mensagemErro, errosPorCampo, enviar }
}
