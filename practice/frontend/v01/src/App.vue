<!-- src/App.vue -->
<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
  <div>
    <!-- 헤더 -->
    <header style="padding: 1rem; border-bottom: 1px solid #ccc;">
      <nav
        style="
          display: flex;
          justify-content: space-between;
          align-items: center;
          max-width: 900px;
          margin: 0 auto;
        "
      >
        <RouterLink
          to="/"
          style="font-weight: bold; text-decoration: none; color: black;"
        >
          Student Admin
        </RouterLink>

        <div style="display: flex; gap: 1rem;">
          <RouterLink
            to="/students"
            style="text-decoration: none; color: gray;"
            active-class="active"
          >
            목록
          </RouterLink>
          <RouterLink
            to="/students/create"
            style="text-decoration: none; color: gray;"
            active-class="active"
          >
            등록
          </RouterLink>
        </div>
      </nav>
    </header>

    <!-- 메인 -->
    <main style="max-width: 900px; margin: 2rem auto; padding: 0 1rem;">
      <RouterView v-slot="{ Component }">
        <component :is="Component" />
      </RouterView>
    </main>

    <!-- 푸터 -->
    <footer
      style="border-top: 1px solid #ccc; text-align: center; padding: 1rem; color: #666;"
    >
      © {{ new Date().getFullYear() }} Student Admin
    </footer>
  </div>
</template>

<style>
/* 활성 링크 표시 */
.router-link-active {
  color: black;
  font-weight: bold;
  text-decoration: underline;
}
</style>
