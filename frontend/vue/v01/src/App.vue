<script setup>

// 반응형 데이터 생성을 위한 ref 불러오기
import { ref } from 'vue';

// newTodo - 할 일 생성을 위한 입력창
// 빈 문자열 형태로 저장 (반응형 데이터)
const newTodo = ref('');

// todos - 할 일 저장 및 출력을 위한 목록
// 빈 배열 형태로 저장 (반응형 데이터)
const todos = ref([]);

// 할 일을 목록에 추가하는 함수 정의
function todoAdd()
{
  // newTodo.value 값의 앞뒤 공백을 제거하여 text 변수에 저장
  const text = newTodo.value.trim();

  // text가 빈 값일 경우 함수 종료
  if (!text) return;

  // todos.value의 배열에 객체 형태로 값 저장
  // { id: ~, title: ~, completed: ~ }
  todos.value.push({ id: Date(), title: text, completed: false });

  // newTodo.value 값 초기화
  newTodo.value = '';
}

// 특정 할 일을 목록에서 삭제하는 함수 정의
function todoDelete(id)
{
  // todos.value의 객체들을 처음부터 돌면서 해당하는 id 값을 제외하고 모두 todos.value에 다시 저장
  todos.value = todos.value.filter(t => t.id !== id);
}

// 전체 할 일을 목록에서 삭제하는 함수 정의
function todoClear()
{
  // todos.value를 빈 배열로 저장
  todos.value = [];
}

// 선택한 한 일을 목록에서 삭제하는 함수 정의
function todoSelectDelete()
{
  // todos.value의 객체를 처음부터 돌면서 completed가 false인 객체들만 todos.value에 다시 저장
  todos.value = todos.value.filter(t => t.completed === false);
}

</script>


<template>
<!--

To-do List

입력창: v-model="newTodo" / @keyup.enter="todoAdd"

<hr>

할 일 목록

전체삭제/선택삭제 버튼 활성화

<ul>
  <li v-for="t in todos" :key="t.id">
    <input type="checkbox" v-model="t.completed">
    <span :style="{ textDecoration : t.completed ? 'line-through' : 'none'}">
      {{ t.title }}
    </span>
  </li>
</ul>

-->

<h1>To-do List</h1>

<input
  v-model="newTodo"
  placeholder="할 일을 입력하세요."
  @keyup.enter="todoAdd()"
/>
<button @click="todoAdd()">입력</button>

<p>할 일 목록</p>

<hr>

<button @click="todoClear()">전체삭제</button>
<button @click="todoSelectDelete()">선택삭제</button>

<ul>
  <li v-for="t in todos" :key="t.id">
    <input type="checkbox" v-model="t.completed">
    <span :style="{ textDecoration : t.completed ? 'line-through' : 'none'}">
      {{ t.title }}
      <button @click="todoDelete(t.id)">삭제</button>
    </span>
  </li>
</ul>

</template>


<style>
  /* 기본(라이트 모드) 스타일 */
  body {
    background-color: white;
    color: black;
    transition: background-color 0.3s, color 0.3s;
  }

  /* 🌙 다크 모드일 때 자동 적용 */
  @media (prefers-color-scheme: dark) {
    body {
      background-color: #121212;
      color: #e0e0e0;
    }
  }
</style>
