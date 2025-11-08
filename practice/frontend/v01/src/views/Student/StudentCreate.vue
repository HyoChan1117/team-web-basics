<script setup>
import { useRouter } from 'vue-router'
import { useStudentsStore } from '@/stores/students'
import StudentForm from '@/components/Student/StudentForm.vue'

const s = useStudentsStore()
const router = useRouter()

async function handleSubmit(payload) {
  await s.create(payload)
  router.push('/students')   // 등록 후 목록으로
}
</script>

<template>
  <div>
    <h2>학생 등록</h2>
    <StudentForm
      :initial="{}"
      :showStdId="true"
      :requirePassword="true"
      @submit="handleSubmit"
      @cancel="() => router.back()"
    />
  </div>
</template>
