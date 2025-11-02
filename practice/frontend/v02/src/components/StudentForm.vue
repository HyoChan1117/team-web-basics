<script setup>
import { reactive, watch, computed } from 'vue'
import { newStudent } from '../types/student.js'

const props = defineProps({
  modelValue: { type: Object, default: () => newStudent() },
  editing: { type: Boolean, default: false },
})
const emit = defineEmits(['update:modelValue', 'submit'])

const form = reactive({ ...newStudent(), ...props.modelValue })
watch(() => props.modelValue, (v) => Object.assign(form, newStudent(), v || {}))

const canSubmit = computed(() =>
  form.std_id && form.email && (props.editing || form.password) && form.name && form.birth && form.gender
)

function onSubmit() {
  emit('submit', { ...form })
}
</script>

<template>
  <form @submit.prevent="onSubmit" style="display:grid;gap:8px;max-width:520px;">
    <label>학번
      <input v-model="form.std_id" :disabled="editing" required>
    </label>
    <label>이메일
      <input v-model="form.email" type="email" required>
    </label>
    <label>비밀번호
      <input v-model="form.password" type="password" :required="!editing" placeholder="수정 시 비우면 변경 없음">
    </label>
    <label>이름
      <input v-model="form.name" required>
    </label>
    <label>생년월일
      <input v-model="form.birth" type="date" required>
    </label>
    <label>성별
      <select v-model="form.gender" required>
        <option value="M">남</option>
        <option value="F">여</option>
      </select>
    </label>
    <label>입학년도
      <input v-model.number="form.admission_year" type="number" min="1990" max="2100" required>
    </label>
    <label>현재 학년
      <input v-model.number="form.current_year" type="number" min="1" max="8" required>
    </label>
    <label>학적 상태
      <select v-model="form.status">
        <option>재학</option><option>휴학</option><option>졸업</option><option>제적</option><option>자퇴</option>
      </select>
    </label>

    <button type="submit" :disabled="!canSubmit">저장</button>
  </form>
</template>
