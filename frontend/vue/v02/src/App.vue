<script setup>

// 반응형 변수 선언을 위한 ref 불러오기
import { ref } from 'vue';

// 빈 문자열 선언
const newTodo = ref('');

// 빈 배열 선언
const todos = ref([]);

// 입력
function addTodo()
{
  const text = newTodo.value.trim();
  if (!text) return;

  todos.value.push({ id: Date.now(), title: text, completed: false, modID: null});
  newTodo.value = '';
}

// 삭제
// 특정 객체 삭제
function deleteTodo(id)
{
  todos.value = todos.value.filter(t => t.id !== id);
}

// 전체 삭제
function clearTodo()
{
  todos.value = [];
}

// 선택 삭제
function selectDeleteTodo()
{
  todos.value = todos.value.filter(t => t.completed === false)
}

// 수정
// 수정하고자 하는 id 번호 부여
function modifyID(self, id)
{
  self.modID = id;
}

// 할 일 수정
function modifyTodo(id, val)
{
  const modify = todos.value.find(t => t.modID === id);
  modify.modID = val;
}

</script>


<template>

<h1>To-do List</h1>

<p>
입력: 
<input
  v-model="newTodo"
  placeholder="할 일을 입력하세요."
  @keyup.enter="addTodo"
/>
</p>

<p>할 일 목록</p>

<hr>

<button @click="clearTodo">전체삭제</button>
<button @click="selectDeleteTodo">선택삭제</button>

<ul>
  <li v-for="t in todos" :key="t.id">
    <input type="checkbox" v-model="t.completed">
    <span v-if="t.id !== t.modID"
      :style="{ textDecoration : t.completed ? 'line-through' : 'none' }">
      {{ t.title }}
      <button @click="modifyID(t, t.id)">수정</button>
      <button @click="deleteTodo(t.id)">삭제</button>
    </span>
    <input v-else type="text" v-model="t.title" @keyup.enter="modifyTodo(t.id, t.title)">
    
  </li>
</ul>

</template>