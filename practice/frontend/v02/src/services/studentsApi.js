import { api } from '../lib/api.js'

export default {
  list: (page = 1, limit = 20) => api.get(`/students?page=${page}&limit=${limit}`),
  get:  (id) => api.get(`/students/${id}`),
  create: (payload) => api.post('/students', payload),
  update: (id, payload) => api.put(`/students/${id}`, payload),
  remove: (id) => api.delete(`/students/${id}`),
}
