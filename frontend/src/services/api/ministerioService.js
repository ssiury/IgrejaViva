import { http } from '@/services/http'
import { apiRoutes } from '@/config/apiRoutes'

export const ministerioService = {
  async listar() {
    const { data } = await http.get(apiRoutes.ministerios)
    return data.dados
  },
}
