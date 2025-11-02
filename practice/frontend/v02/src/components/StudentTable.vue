<script setup>
const props = defineProps({
  rows: { type: Array, default: () => [] },
  loading: { type: Boolean, default: false },
})
const emit = defineEmits(['view','edit','remove'])
</script>

<template>
  <div>
    <p v-if="loading">불러오는 중...</p>
    <table v-else border="1" cellpadding="6" cellspacing="0" style="width:100%;">
      <thead>
        <tr>
          <th>학번</th><th>이름</th><th>생년월일</th><th>성별</th><th>상태</th><th>액션</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="r in rows" :key="r.std_id">
          <td>{{ r.std_id }}</td>
          <td>{{ r.name }}</td>
          <td>{{ r.birth }}</td>
          <td>{{ r.gender }}</td>
          <td>{{ r.status }}</td>
          <td>
            <button @click="$emit('view', r.std_id)">보기</button>
            <button @click="$emit('edit', r.std_id)">수정</button>
            <button @click="$emit('remove', r.std_id)">삭제</button>
          </td>
        </tr>
        <tr v-if="rows.length === 0"><td colspan="6">데이터 없음</td></tr>
      </tbody>
    </table>
  </div>
</template>
