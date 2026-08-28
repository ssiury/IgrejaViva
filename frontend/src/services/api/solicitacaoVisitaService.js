import { http } from '@/services/http'
import { apiRoutes } from '@/config/apiRoutes'

export const solicitacaoVisitaService = {
  async criar(dados) {
    const { data } = await http.post(apiRoutes.solicitacoesVisita, dados)
    return data.dados
  },
}
