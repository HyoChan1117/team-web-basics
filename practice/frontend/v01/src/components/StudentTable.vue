<!-- src/components/StudentsTable.vue -->
<script setup>
import { onMounted, watch } from "vue";
import { useStudents } from "../composables/useStudents.js";

const { list, loading, error, loadList, removeOne } = useStudents();

onMounted(loadList);

watch(list, v => {
  console.log('list isArray?', Array.isArray(v), 'length:', v?.length, 'first:', v?.[0]);
}, { immediate: true });
</script>


<template>
  <div>
    <h2 class="text-xl font-bold mb-2">학생 목록</h2>

    <div v-if="loading">불러오는 중...</div>
    <div v-else-if="error" class="text-red-600">오류: {{ error }}</div>

    <table v-else class="min-w-full border">
      <thead>
        <tr class="bg-gray-50">
          <th class="p-2 border">std_id</th>
          <th class="p-2 border">name</th>
          <th class="p-2 border">birth</th>
          <th class="p-2 border">gender</th>
          <th class="p-2 border">status</th>
          <th class="p-2 border">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="s in list" :key="s.std_id">
          <td class="p-2 border">{{ s.std_id }}</td>
          <td class="p-2 border">{{ s.name }}</td>
          <td class="p-2 border">{{ s.birth }}</td>
          <td class="p-2 border">{{ s.gender }}</td>
          <td class="p-2 border">{{ s.status }}</td>
          <td class="p-2 border space-x-2">
            <RouterLink :to="`/students/${s.std_id}`" class="underline">보기</RouterLink>
            <RouterLink :to="`/students/${s.std_id}/edit`" class="underline">수정</RouterLink>
            <button class="text-red-600" @click="onDelete(s.std_id)">삭제</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
