<!-- src/pages/StudentEditPage.vue -->
<script setup>
import { onMounted, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useStudents } from "../composables/useStudents.js";
import StudentForm from "../components/StudentForm.vue";

const route = useRoute();
const router = useRouter();
const id = route.params.std_id; // JS에서는 타입 단언 불필요

const { detail, loadOne, updateOne, loading, error } = useStudents();

onMounted(() => loadOne(id));

const initial = computed(() => detail ?? undefined);

/**
 * 학생 수정 처리
 * @param {Object} payload - 수정할 학생 정보
 */
async function handleSubmit(payload) {
  try {
    await updateOne(id, payload);
    alert("수정 완료");
    router.push(`/students/${id}`);
  } catch (e) {
    alert("수정 실패");
  }
}
</script>

<template>
  <h2 class="text-xl font-bold mb-4">학생 수정</h2>

  <div v-if="loading">불러오는 중...</div>
  <div v-else-if="error" class="text-red-600">오류: {{ error }}</div>

  <StudentForm
    v-else-if="initial"
    mode="edit"
    :initial="initial"
    @submit="handleSubmit"
  />

  <div v-else>데이터 없음</div>
</template>
