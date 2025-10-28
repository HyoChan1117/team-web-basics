<!-- src/components/TodoList.vue -->
<template>
  <ul>
    <TodoItem
      v-for="t in todos"
      :key="t.id"
      :todo="t"
      :editing-id="editingId"
      @start-edit="editingId = $event"
      @cancel-edit="editingId = null"
      @save-edit="onSave"
      @remove="$emit('remove', $event)"
      @toggle="$emit('toggle', $event)"
    />
  </ul>
</template>

<script setup>
import { ref } from 'vue';
import TodoItem from './TodoItem.vue';

defineProps({ todos: { type: Array, default: () => [] } });
const emits = defineEmits(['remove','toggle','save']);

const editingId = ref(null);

function onSave({ id, title }) {
  emits('save', { id, title });
  editingId.value = null;
}
</script>
