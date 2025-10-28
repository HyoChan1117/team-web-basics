<!-- src/pages/TodoPage.vue -->
<template>
  <div>
    <h1>To-Do List</h1>

    <TodoInput v-model="newTitle" @add="add" />

    <TodoFilters
      :remaining="remaining"
      @change="setFilter"
    />

    <TodoList
      :todos="filteredTodos"
      @remove="removeTodo($event)"
      @toggle="({ id, done }) => toggle(id, done)"
      @save="({ id, title }) => updateTitle(id, title)"
    />

    <TodoActions
      :completed-count="completedCount"
      :disabled-all="todos.length === 0"
      @toggle-all="toggleAll"
      @clear-completed="clearCompleted"
    />
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useTodos } from '../composables/useTodos';

import TodoInput from '../components/TodoInput.vue';
import TodoFilters from '../components/TodoFilters.vue';
import TodoList from '../components/TodoList.vue';
import TodoActions from '../components/TodoActions.vue';

const {
  todos, newTitle, filter,
  remaining, completedCount,
  add, removeTodo, updateTitle, toggle,
  clearCompleted, toggleAll, setFilter
} = useTodos();

const filteredTodos = computed(() => {
  if (filter.value === 'active') return todos.value.filter(t => !t.completed);
  if (filter.value === 'completed') return todos.value.filter(t => t.completed);
  return todos.value;
});
</script>
