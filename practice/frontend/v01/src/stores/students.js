import { defineStore } from 'pinia'
import { StudentsApi } from '@/api/students'

export const useStudentsStore = defineStore('students', {
  state: () => ({
    list: [],
    item: null,
    loading: false,
    meta: { page:1, pages:1, total:0, limit:20 },
    error: null,
  }),
  actions: {
    async fetchList(page=1) {
      this.loading = true
      this.error = null
      try {
        const res = await StudentsApi.list(page, this.meta.limit)
        this.list = Array.isArray(res) ? res : (res.data || [])
        if (!Array.isArray(res) && res.meta)
          this.meta = res.meta
        else
          this.meta = { page:1, pages:1, total:this.list.length, limit:this.list.length }
      } catch (e) {
        this.error = e
      } finally {
        this.loading = false
      }
    },
    async fetchOne(id) {
      this.loading = true
      this.error = null
      try { this.item = await StudentsApi.get(id) }
      catch (e) { this.error = e; this.item = null }
      finally { this.loading = false }
    },
    async create(payload) {
      this.loading = true
      try { return await StudentsApi.create(payload) }
      finally { this.loading = false }
    },
    async update(id, payload) {
      this.loading = true
      try { return await StudentsApi.update(id, payload) }
      finally { this.loading = false }
    },
    async removeById(id) {
      if (!confirm('정말 삭제할까요?')) return
      this.loading = true
      try {
        await StudentsApi.remove(id)
        this.list = this.list.filter(r => String(r.std_id) !== String(id))
      } finally { this.loading = false }
    },
  },
})
