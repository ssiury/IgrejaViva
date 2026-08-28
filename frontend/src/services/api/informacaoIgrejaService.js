import { http } from '@/services/http'
import { apiRoutes } from '@/config/apiRoutes'

export const informacaoIgrejaService = {
  async obter() {
    const { data } = await http.get(apiRoutes.informacoesIgreja)
    return data.dados
  },
}
