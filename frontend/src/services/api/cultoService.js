import { http } from '@/services/http'
import { apiRoutes } from '@/config/apiRoutes'

export const cultoService = {
  async listar() {
    const { data } = await http.get(apiRoutes.cultos)
    return data.dados
  },
}
