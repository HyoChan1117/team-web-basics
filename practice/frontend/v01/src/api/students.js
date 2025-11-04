import { request } from './client'

export const StudentsApi = {
  list(page = 1, limit = 2) {
    return request('GET', `/students?page=${page}&limit=${limit}`)
  },
  get(id) {
    return request('GET', `/students/${id}`)
  },
  create(payload) {
    return request('POST', `/students`, payload)
  },
  update(id, payload) {
    return request('PUT', `/students/${id}`, payload)
  },
  remove(id) {
    return request('DELETE', `/students/${id}`)
  },
}
