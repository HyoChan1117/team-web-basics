<script setup>
// 반응형 데이터를 위한 'ref' 불러오기
import { ref } from 'vue';

// newTodo - 빈 문자열 반응형 데이터 저장
// 할 일 입력창
const newTodo = ref('');

// todos - 빈 배열 반응형 데이터 저장
// 할 일 목록
const todos = ref([]);

// 이벤트 정의
// 할 일 목록에 입력값 추가하는 함수 정의
function addTodo()
{
  // 입력값의 앞뒤 공백을 제거하여 text 변수에 저장
  const text = newTodo.value.trim();

  // text가 빈 값이면 함수 종료
  if (!text) return;

  // todos.value에 연관 배열 형태의 객체 저장
  todos.value.push({ id: Date.now(), content: text, completed: false, modifyId: null, editingContent: text });

  // newTodo.value 값 초기화
  newTodo.value = '';
}

// 할 일 목록에서 특정 할 일을 삭제하는 함수 정의
function deleteTodo(id)
{
  // 해당 id의 할 일을 제외하고 나머지 할 일 todos.value에 저장
  todos.value = todos.value.filter(t => t.id !== id);
}

// 할 일 목록에서 전체 할 일을 삭제하는 함수 정의
function clearTodo()
{
  // todos.value 초기화
  todos.value = [];
}

// 할 일 목록에서 할 일을 선택하여 삭제하는 함수 정의
function selectDeleteTodo()
{
  // todos.value의 객체들 중 completed가 false인 객체만 todos.value에 저장
  todos.value = todos.value.filter(t => t.completed === false);
}

// 할 일 목록에서 수정 id에 해당 id를 부여하는 함수 정의
function modifyIdTodo(self, id)
{
  // 해당 id 값을 수정하고자 하는 id에 저장
  self.modifyId = id;
}

// 할 일 목록에서 특정 할 일을 수정하는 함수 정의
function modifyTodo(id, content)
{
  // 할 일 목록에서 특정 id의 객체를 찾아 modifyObj 변수에 저장
  const modifyObj = todos.value.find(t => t.id === id);

  // modifyObj.content에 수정되는 내용 저장
  modifyObj.content = content;

  // 수정된 내용을 modifyObj.editingContent에 임시 저장
  modifyObj.editingContent = content;

  // modifyObj.modifyId 초기화
  modifyObj.modifyId = null;
}

// 수정 취소 함수 정의
function modifyCancelTodo(self, id)
{
  // 이전 내용 찾아서 저장
  const prev = todos.value.find(t => t.id === id);

  // 이전 내용을 현재 내용에 저장
  self.content = self.editingContent;

  // 해당 id 값을 수정하고자 하는 id에 저장
  self.modifyId = null;
}

</script>


<template>
<!--
To-do List

할 일 입력
<input ~>

할 일 목록
전체삭제, 선택삭제 버튼 활성화

1. if 수정ID와 현재ID와 같다면
2. else

-->

<h1>To-do List</h1>

<p>할 일 입력</p>
<input
  v-model="newTodo"
  placeholder="할 일을 입력하세요."
  @keyup.enter="addTodo"
/>

<hr>

<p>할 일 목록</p>
<button @click="clearTodo">전체삭제</button>
<button @click="selectDeleteTodo">선택삭제</button>

<ul>
  <li v-for="t in todos" :key="t.id">
    <template v-if="t.id !== t.modifyId">
      <input type="checkbox" v-model="t.completed">
      <span :style="{textDecoration : t.completed ? 'line-through' : 'none'}">
        {{ t.content }}
      </span>
      <button @click="modifyIdTodo(t, t.id)">수정</button>
      <button @click="deleteTodo(t.id)">삭제</button>
    </template>

    <template v-else>
      <input type="text" v-model="t.content" @keyup.enter="modifyTodo(t.id, t.content)">
      <button @click="modifyTodo(t.id, t.content)">제출</button>
      <button @click="modifyCancelTodo(t, t.id)">취소</button>
    </template>


  </li>
</ul>
</template>