<template>
  <div>
    <!-- 전체 앱의 제목 -->
    <h1>Students</h1>

    <!-- 라우터 링크: 클릭 시 페이지 전환 -->
    <!-- 목록 페이지로 이동 -->
    <router-link :to="{ name: 'StudentsList' }">
      <button>목록</button>
    </router-link>

    <!-- 등록 페이지로 이동 -->
    <router-link :to="{ name: 'StudentCreate' }">
      <button>등록</button>
    </router-link>

    <!-- 현재 활성화된 라우트에 따라 해당하는 페이지 컴포넌트를 표시 -->
    <router-view />
  </div>
</template>