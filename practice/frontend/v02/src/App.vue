<template>
  <div style="max-width:960px;margin:24px auto;padding:8px;">
    <header style="display:flex;gap:12px;align-items:center;margin-bottom:16px;">
      <h1 style="margin:0;">Students</h1>
      <router-link to="/">목록</router-link>
      <router-link to="/students/create">신규 등록</router-link>
    </header>
    <router-view />
  </div>
</template>