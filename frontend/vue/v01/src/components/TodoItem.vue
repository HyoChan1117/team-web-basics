<!-- src/components/TodoItem.vue -->
<template>
  <li>
    <input type="checkbox" v-model="todo.completed" @change="$emit('toggle', { id: todo.id, done: todo.completed })" />

    <span v-if="editingId !== todo.id" @dblclick="startEdit()">
      {{ todo.title }}
    </span>

    <input
      v-else
      v-model.trim="editText"
      placeholder="내용 수정"
      @keydown.enter.prevent="save()"
      @keydown.esc.prevent="cancel()"
      @blur="save()"
    />

    <button v-if="editingId !== todo.id" @click="startEdit()">수정</button>
    <button v-else @click="cancel()">취소</button>
    <button @click="$emit('remove', todo.id)">삭제</button>
  </li>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  todo: { type: Object, required: true },
  editingId: { type: [String, Number, null], default: null },
});
const emits = defineEmits(['start-edit','cancel-edit','save-edit','remove','toggle']);

const editText = ref('');

function startEdit() {
  emits('start-edit', props.todo.id);
  editText.value = props.todo.title;
}
function cancel() {
  emits('cancel-edit');
  editText.value = '';
}
function save() {
  // blur와 enter 중복 방지: 상위에서 현재 editingId 체크해줄 것
  emits('save-edit', { id: props.todo.id, title: editText.value });
}
function onToggle(e) {
  emits('toggle', { id: props.todo.id, done: e.target.checked });
}
</script>
