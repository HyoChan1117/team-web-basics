<!-- 전체 앱 틀 -->
<script setup>
// script setup 구문: Vue 3 Composition API의 축약형 문법
// setup() 함수 안의 내용을 더 간단하게 작성할 수 있게 해줌
import { ref } from 'vue';

const newTodo = ref('');
const todos = ref([]); // { id, title, completed }

function addTodo() {
  const text = newTodo.value.trim();
  if (!text) return;
  todos.value.push({ id: Date.now(), title: text, completed: false });
  newTodo.value = '';
}

function toggleTodo(id) {
  const t = todos.value.find(t => t.id === id);
  if (t) t.completed = !t.completed;
}

function removeTodo(id) {
  todos.value = todos.value.filter(t => t.id !== id);
}
</script>

<template>
  <div>
    <h1>Todo List</h1>

    <input
      v-model="newTodo"
      placeholder="할 일을 입력하세요"
      @keyup.enter="addTodo"
    />

    <ul>
      <li v-for="t in todos" :key="t.id">
        <input type="checkbox" v-model="t.completed" />
        <span :style="{ textDecoration: t.completed ? 'line-through' : 'none' }">
          {{ t.title }}
        </span>
        <button @click="removeTodo(t.id)">삭제</button>
      </li>
    </ul>
  </div>
</template>
