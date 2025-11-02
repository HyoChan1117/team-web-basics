<!-- src/pages/StudentDetailPage.vue -->
<script setup>
import { onMounted } from "vue";
import { useRoute } from "vue-router";
import { useStudents } from "../composables/useStudents.js";

const route = useRoute();
const id = route.params.std_id;

const { detail, loading, error, loadOne } = useStudents();

onMounted(() => loadOne(id));
</script>

<template>
  <div>
    <h2 class="text-xl font-bold mb-4">학생 상세</h2>

    <div v-if="loading">불러오는 중...</div>
    <div v-else-if="error" class="text-red-600">오류: {{ error }}</div>
    <div v-else-if="!detail">데이터가 없습니다.</div>

    <div v-else class="space-y-1">
      <div><b>std_id:</b> {{ detail.std_id }}</div>
      <div><b>name:</b> {{ detail.name }}</div>
      <div><b>email:</b> {{ detail.email }}</div>
      <div><b>birth:</b> {{ detail.birth }}</div>
      <div><b>gender:</b> {{ detail.gender }}</div>
      <div><b>admission_year:</b> {{ detail.admission_year }}</div>
      <div><b>current_year:</b> {{ detail.current_year }}</div>
      <div><b>status:</b> {{ detail.status }}</div>
    </div>
  </div>
</template>
