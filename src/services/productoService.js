import api from './api'

export default {

  obtenerProductos() {
    return api.get('/productos')
  },

  crearProducto(data) {
    return api.post('/productos', data)
  },

  actualizarProducto(id, data) {
    return api.put(`/productos/${id}`, data)
  },

  eliminarProducto(id) {
    return api.delete(`/productos/${id}`)
  }

}