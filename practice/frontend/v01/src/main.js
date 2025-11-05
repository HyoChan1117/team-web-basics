import { createApp } from 'vue'      // createApp 함수 가져오기
import { createPinia } from 'pinia'  // store 생성용 함수 가져오기
import App from './App.vue'          // 최상위 루트 컴포넌트 가져오기
import router from './router'        // 라우터 설정 파일 가져오기

createApp(App)           // Vue 앱 인스턴스 생성
    .use(createPinia())  // 전역 상태 관리(Pinia) 연결
    .use(router)         // 라우터 연결
    .mount('#app')       // index.html 안의 id="app" 요소에 앱 마운트
