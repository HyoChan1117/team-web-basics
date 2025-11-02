<script setup>
import { onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import useStudents from '../composables/useStudents.js'

const route = useRoute()
const router = useRouter()
const s = useStudents()

onMounted(() => s.fetchOne(route.params.std_id))

function goEdit() { router.push(`/students/${route.params.std_id}/edit`) }
</script>

<template>
  <div>
    <h2>학생 상세</h2>
    <div v-if="s.loading">로딩중...</div>
    <div v-else-if="!s.item">데이터 없음</div>
    <div v-else style="display:grid;gap:6px;">
      <div><b>학번</b> {{ s.item.std_id }}</div>
      <div><b>이름</b> {{ s.item.name }}</div>
      <div><b>이메일</b> {{ s.item.email }}</div>
      <div><b>생년월일</b> {{ s.item.birth }}</div>
      <div><b>성별</b> {{ s.item.gender }}</div>
      <div><b>입학년도</b> {{ s.item.admission_year }}</div>
      <div><b>현재 학년</b> {{ s.item.current_year }}</div>
      <div><b>상태</b> {{ s.item.status }}</div>
      <div style="margin-top:8px;">
        <button @click="goEdit">수정</button>
      </div>
    </div>
  </div>
</template>
