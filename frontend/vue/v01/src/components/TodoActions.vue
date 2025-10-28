<!-- src/components/TodoActions.vue -->
<template>
  <div>
    <button @click="$emit('toggle-all', true)" :disabled="disabledAll">모두 완료</button>
    <button @click="$emit('toggle-all', false)" :disabled="disabledAll">모두 진행중</button>
    <button @click="$emit('clear-completed')" :disabled="completedCount === 0">
      완료 삭제
    </button>
  </div>
</template>

<script setup>
defineProps({
  completedCount: { type: Number, default: 0 },
  disabledAll: { type: Boolean, default: false }
});
defineEmits(['toggle-all','clear-completed']);
</script>
