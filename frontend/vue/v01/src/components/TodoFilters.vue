<!-- src/components/TodoFilters.vue -->
<template>
  <div>
    <span>{{ remaining }}개 남음</span>
    |
    <button @click="$emit('change','all')">전체</button>
    <button @click="$emit('change','active')">진행중</button>
    <button @click="$emit('change','completed')">완료</button>
  </div>
</template>

<script setup>
defineProps({ remaining: { type: Number, default: 0 } });
defineEmits(['change']);
</script>
