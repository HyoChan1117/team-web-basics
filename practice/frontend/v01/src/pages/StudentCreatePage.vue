<!-- src/pages/StudentCreatePage.vue -->
<script setup>
import { useRouter } from "vue-router";
import { useStudents } from "../composables/useStudents.js";
import StudentForm from "../components/StudentForm.vue";

const router = useRouter();
const { createOne, error, loading } = useStudents();

/**
 * 학생 등록 처리
 * @param {Object} payload - 새 학생 입력 데이터
 */
async function handleSubmit(payload) {
  try {
    const s = await createOne(payload);
    alert("등록 완료");
    router.push(`/students/${s.std_id}`);
  } catch (e) {
    alert("등록 실패");
  }
}
</script>

<template>
  <h2 class="text-xl font-bold mb-4">학생 등록</h2>
  <div v-if="loading">처리 중...</div>
  <div v-else-if="error" class="text-red-600">오류: {{ error }}</div>
  <StudentForm mode="create" @submit="handleSubmit" />
</template>
