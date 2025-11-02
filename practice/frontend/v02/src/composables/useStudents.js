import { ref } from 'vue'
import api from '../services/studentsApi.js'

export default function useStudents() {
  const list = ref([])
  const meta = ref({ page:1, pages:1, total:0, limit:20 })
  const loading = ref(false)
  const item = ref(null)
  const error = ref(null)

  async function fetchList(page = 1) {
    loading.value = true
    error.value = null
    try {
      const res = await api.list(page, meta.value.limit)
      // 백엔드 index()가 meta 포함 응답 (리팩 전이면 res가 배열일 수도)
      if (Array.isArray(res)) { list.value = res; meta.value = { page:1, pages:1, total:res.length, limit:res.length } }
      else { list.value = res.data || []; meta.value = res.meta || meta.value }
    } catch (e) { error.value = e }
    finally { loading.value = false }
  }

  async function fetchOne(id) {
    loading.value = true
    error.value = null
    try { item.value = await api.get(id) }
    catch (e) { error.value = e; item.value = null }
    finally { loading.value = false }
  }

  async function create(payload) {
    loading.value = true
    try { return await api.create(payload) }
    finally { loading.value = false }
  }

  async function update(id, payload) {
    loading.value = true
    try { return await api.update(id, payload) }
    finally { loading.value = false }
  }

  async function removeById(id) {
    if (!confirm('정말 삭제할까요?')) return
    loading.value = true
    try {
      await api.remove(id)
      list.value = list.value.filter(r => String(r.std_id) !== String(id))
    } finally { loading.value = false }
  }

  return { list, meta, item, loading, error, fetchList, fetchOne, create, update, removeById }
}
