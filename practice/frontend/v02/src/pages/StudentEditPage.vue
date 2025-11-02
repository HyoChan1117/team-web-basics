<script setup>
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import StudentForm from '../components/StudentForm.vue'
import useStudents from '../composables/useStudents.js'

const route = useRoute()
const router = useRouter()
const s = useStudents()
const model = ref(null)

onMounted(async () => {
  await s.fetchOne(route.params.std_id)
  model.value = { ...s.item, password: '' } // 비번 변경 안 하면 빈값 유지
})

async function handleSubmit(payload) {
  const { password, ...rest } = payload
  // 비번이 비어있으면 전송에서 제거(백엔드 update가 그대로 SET 하지 않게 화이트리스트 권장)
  const body = password ? payload : rest
  await s.update(route.params.std_id, body)
  alert('수정되었습니다.')
  router.push(`/students/${route.params.std_id}`)
}
</script>

<template>
  <div>
    <h2>학생 수정</h2>
    <div v-if="!model">로딩중...</div>
    <StudentForm v-else :model-value="model" :editing="true" @submit="handleSubmit" />
  </div>
</template>
