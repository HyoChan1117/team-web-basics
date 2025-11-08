<script setup>
import { onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useStudentsStore } from '@/stores/students'

const s = useStudentsStore()
const route = useRoute()
const router = useRouter()

onMounted(() => s.fetchOne(route.params.std_id))
async function confirmDelete() {
  await s.removeById(route.params.std_id)
  router.push('/')
}
</script>

<template>
  <div>
    <h2>학생 삭제</h2>
    <p v-if="s.loading">로딩중...</p>
    <div v-else-if="s.item">
      <p>정말 삭제하시겠습니까?</p>
      <ul>
        <li>학번: {{ s.item.std_id }}</li>
        <li>이름: {{ s.item.name }}</li>
      </ul>
      <button @click="confirmDelete" :disabled="s.loading">삭제</button>
      <button @click="router.back()">취소</button>
    </div>
    <p v-else>데이터 없음</p>
  </div>
</template>
