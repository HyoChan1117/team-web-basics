<script setup>
import { reactive, watchEffect } from 'vue'

const props = defineProps({
  initial: {
    type: Object,
    default: () => ({
      std_id: '',
      email: '',
      password: '',
      name: '',
      birth: '',
      gender: 'M',
      admission_year: new Date().getFullYear(),
      current_year: 1,
      status: '재학',
    }),
  },
  showStdId: { type: Boolean, default: true }, // 수정폼에서 학번 입력 숨기고 싶을 때 false
  requirePassword: { type: Boolean, default: true }, // 수정폼이면 비번 요구 X
})

const emit = defineEmits(['submit', 'cancel'])

// 반응형 사본 (부모 initial이 바뀌면 즉시 동기화)
const form = reactive({ ...props.initial })
watchEffect(() => Object.assign(form, props.initial))

function onSubmit() {
  // 최소 필수 필드 체크
  const need = ['email', 'name', 'birth', 'gender']
  if (props.showStdId) need.unshift('std_id')
  if (props.requirePassword) need.push('password')

  for (const k of need) {
    if (!String(form[k] ?? '').trim()) {
      alert(`${k} 값을 입력하세요.`)
      return
    }
  }
  emit('submit', { ...form })
}
</script>

<template>
  <form @submit.prevent="onSubmit">
    <div v-if="showStdId">
      <label>학번</label>
      <input v-model="form.std_id" />
    </div>

    <div>
      <label>이메일</label>
      <input v-model="form.email" type="email" />
    </div>

    <div v-if="requirePassword">
      <label>비밀번호</label>
      <input v-model="form.password" type="password" />
    </div>

    <div>
      <label>이름</label>
      <input v-model="form.name" />
    </div>

    <div>
      <label>생년월일</label>
      <input v-model="form.birth" type="date" />
    </div>

    <div>
      <label>성별</label>
      <select v-model="form.gender">
        <option value="M">M</option>
        <option value="F">F</option>
      </select>
    </div>

    <div>
      <label>입학년도</label>
      <input v-model.number="form.admission_year" type="number" />
    </div>

    <div>
      <label>현재 학년</label>
      <input v-model.number="form.current_year" type="number" min="1" max="4" />
    </div>

    <div>
      <label>학적 상태</label>
      <select v-model="form.status">
        <option>재학</option><option>휴학</option>
        <option>졸업</option><option>제적</option><option>자퇴</option>
      </select>
    </div>

    <div style="margin-top:8px;">
      <button type="submit">저장</button>
      <button type="button" @click="$emit('cancel')">취소</button>
    </div>
  </form>
</template>
