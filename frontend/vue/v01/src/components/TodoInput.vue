<!-- src/components/TodoInput.vue -->
<template>
  <div>
    <input
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      @keyup.enter="onEnter"
      placeholder="할 일 입력 후 Enter"
    />
    <button @click="$emit('add')" :disabled="!modelValue?.trim()">추가</button>
  </div>
</template>

<script setup>
const props = defineProps({ modelValue: String });
const emits = defineEmits(['update:modelValue','add']);

function onEnter(e) {
  // 한글 IME 조합중 enter 방지 (선택)
  if (e.isComposing) return;
  emits('add');
}
</script>
