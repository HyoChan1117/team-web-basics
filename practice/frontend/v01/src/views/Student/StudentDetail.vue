<script setup>
import { onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useStudentsStore } from '@/stores/students'

const s = useStudentsStore()
const route = useRoute()
const router = useRouter()

onMounted(() => s.fetchOne(route.params.std_id))
</script>

<template>
  <div>
    <h2>학생 상세</h2>

    <p v-if="s.loading">로딩중...</p>
    <div v-else-if="s.item">
      <p>학번: {{ s.item.std_id }}</p>
      <p>이름: {{ s.item.name }}</p>
      <p>이메일: {{ s.item.email }}</p>
      <p>생년월일: {{ s.item.birth }}</p>
      <p>성별: {{ s.item.gender }}</p>
      <p>상태: {{ s.item.status }}</p>

      <button @click="router.push('/students/' + s.item.std_id + '/edit')">수정</button>
      <button @click="router.push('/students/' + s.item.std_id + '/delete')">삭제</button>
      <button @click="router.back()">뒤로</button>
    </div>
    <p v-else>데이터 없음</p>
  </div>
</template>
