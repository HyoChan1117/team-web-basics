<script setup>
import { onMounted, reactive } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useStudentsStore } from '@/stores/students'
import StudentForm from '@/components/Student/StudentForm.vue'

const s = useStudentsStore()
const route = useRoute()
const router = useRouter()

const model = reactive({})

onMounted(async () => {
  await s.fetchOne(route.params.std_id)
  Object.assign(model, s.item || {})
})

async function handleSubmit(payload) {
  await s.update(route.params.std_id, payload)
  router.push('/students/' + route.params.std_id)
}
</script>

<template>
  <div>
    <h2>학생 수정</h2>
    <p v-if="s.loading">로딩중...</p>
    <StudentForm
      v-else
      :initial="model"
      :showStdId="false"
      :requirePassword="false"
      @submit="handleSubmit"
      @cancel="() => router.back()"
    />
  </div>
</template>
