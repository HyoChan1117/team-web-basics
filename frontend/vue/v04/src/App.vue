<script setup>
// 반응형 데이터를 위한 'ref' 불러오기
import { ref } from 'vue';

// 할 일 입력창
// newTodo - 빈 문자열 저장 (반응형 데이터)
const newTodo = ref('');

// 할 일 목록
// todos - 빈 배열 저장 (반응형 데이터)
const todos = ref([]);

// 할 일 목록에 할 일 추가하는 함수 정의
// todos.value에 객체 형태의 할 일 추가
function addTodo()
{
    // newTodo의 앞뒤 공백을 제거하여 text 변수에 저장
    const text = newTodo.value.trim();

    // text가 빈 값이면 함수 종료
    if (!text) {
        newTodo.value = '';
        return;
    }
        
    // todos.value 할 일 목록에 text 추가
    todos.value.push({ id: Date.now(), content: text, completed: false, modifyId: null, editingContent: text });

    // newTodo.value 초기화
    newTodo.value = '';
}

// 특정 할 일을 목록에서 삭제하는 함수 정의
function deleteTodo(id)
{
    // id에 해당하는 할 일을 제외한 나머지 객체를 다시 todos.value에 저장
    todos.value = todos.value.filter(t => t.id !== id);
}

// 전체 할 일을 목록에서 삭제하는 함수 정의
function clearTodo()
{
    // todos.value 배열을 초기화
    todos.value = [];
}

// 선택한 할 일을 목록에서 삭제하는 함수 정의
function deleteSelectTodo()
{
    // todos.value의 객체에서 conpleted가 false인 객체만 다시 todos.value에 저장
    todos.value = todos.value.filter(t => t.completed === false);
}

// 수정이 필요한 todos.value의 객체에서 modifyId에 현재 id값을 저장하는 함수 정의
function modifyIdTodo(self, id)
{
    // 현재 객체의 modifyId에 현재 id 값을 저장
    self.modifyId = id;
}

// modifyId가 null이 아닌 객체의 content를 업데이트하는 함수 정의
function modifyContentTodo(id, content)
{
    // 현재 id에 해당하는 객체를 modify 변수에 저장
    const modify = todos.value.find(t => t.id === id);

    // 현재 객체의 content에 현재 입력값 저장
    modify.content = content;

    // 현재 객체의 modifyId 초기화
    modify.modifyId = null;

    // 현재 객체의 editingContent에 현재 입력값 저장
    modify.editingContent = content;
}

// 수정 취소하는 함수 정의
function modifyCancelTodo(id)
{
    // 현재 id에 해당하는 객체를 찾아서 modifyCancel 변수에 저장
    const modifyCancel = todos.value.find(t => t.id === id);

    // modifyCancel.content에 modifyCancel.editingContent 값 저장
    modifyCancel.content = modifyCancel.editingContent;
    
    // modifyCancel.modifyId 값 초기화
    modifyCancel.modifyId = null;
}
</script>

<template>
<!--
To-do List

할 일 입력

<hr>
전체삭제 / 선택삭제 버튼 활성화

할 일 목록
if (t.id !== t.modifyId)
체크박스 + 내용 + 수정 + 삭제 버튼 활성화

else
입력창 + 제출 + 취소 버튼 활성화
-->
<h1>To-do List</h1>

<p>할 일 입력</p>
<input
  v-model="newTodo"
  placeholder="할 일을 입력하세요."
  @keyup.enter="addTodo"
/>
<button @click="addTodo">입력</button>

<hr>

<p>할 일 목록</p>
<button @click="clearTodo">전체삭제</button>
<button @click="deleteSelectTodo">선택삭제</button>
<ul>
    <li v-for="t in todos" :key="t.id">
      <template v-if="t.modifyId !== t.id">
        <input type="checkbox" v-model="t.completed">
        <span :style="{'textDecoration' : t.completed ? 'line-through' : 'none'}">
            {{ t.content }}
        </span>
        <button @click="modifyIdTodo(t, t.id)">수정</button>
        <button @click="deleteTodo(t.id)">삭제</button>
      </template>

      <template v-else>
        <input type="text" v-model="t.content" @keyup.enter="modifyContentTodo(t.id, t.content)">
        <button @click="modifyContentTodo(t.id, t.content)">제출</button>
        <button @click="modifyCancelTodo(t.id)">취소</button>
      </template>
    </li>
</ul>
</template>