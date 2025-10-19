<template>
  <h1>영화정보</h1>
  <div>
    <h3 class="bg-yellow" :style="textRed">{{ title }}</h3>
    <p>개봉: {{ year }}</p>
    <p>장르: {{  category }}</p>
  </div>
  <p v-for="(item, i) in foods" :key="i">{{ item }}</p>
</template>

<script>
  export default {
    name: 'App',
    data() {
      return {
        title: "노량",
        year: 2023,
        category: "액션, 드라마",
        textRed: "color: red",
        foods: ["김밥", "순대", "만두"]
      }
    }
  }
</script>
  
<style>
  .bg-yellow {
    background: gold;
    padding: 10px;
  }
</style>
