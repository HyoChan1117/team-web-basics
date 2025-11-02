<!-- src/pages/StudentCreatePage.vue -->
<script setup>
import { useRouter } from 'vue-router'
import StudentForm from '../components/StudentForm.vue'
import useStudents from '../composables/useStudents.js'
import { newStudent } from '../types/student.js'   // ⬅ 여기서 import

const router = useRouter()
const s = useStudents()

async function handleSubmit(payload) {
  await s.create(payload)
  alert('저장되었습니다.')
  router.push('/')
}
</script>

<template>
  <div>
    <h2>학생 등록</h2>
    <!-- ⬇ newStudent() 정상 인식 -->
    <StudentForm :model-value="newStudent()" @submit="handleSubmit" />
  </div>
</template>
