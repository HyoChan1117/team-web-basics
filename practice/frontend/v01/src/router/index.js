// vue-router에서 함수 불러오기
import { createRouter, createWebHistory } from 'vue-router'

// 학생 관련 페이지 컴포넌트 불러오기 (각 경로에서 보여질 화면)
import StudentsList from '@/views/Student/StudentsList.vue'
import StudentCreate from '@/views/Student/StudentCreate.vue'
import StudentDetail from '@/views/Student/StudentDetail.vue'
import StudentEdit from '@/views/Student/StudentEdit.vue'
import StudentDelete from '@/views/Student/StudentDelete.vue'

// export default는 "이 파일에서 기본적으로 내보낼 값 하나"
export default createRouter({

  // URL 변경 감시
  // URL에 맞는 컴포넌트를 router-view에 표시
  history: createWebHistory(),

  // URL 경로(path)와 해당 컴포넌트를 매핑하는 설정 목록
  routes: [
    { path: '/students/', name: 'StudentsList', component: StudentsList },
    { path: '/students/create', name: 'StudentCreate', component: StudentCreate },
    { path: '/students/:std_id', name: 'StudentDetail', component: StudentDetail, props: true },
    { path: '/students/:std_id/edit', name: 'StudentEdit', component: StudentEdit, props: true },
    { path: '/students/:std_id/delete', name: 'StudentDelete', component: StudentDelete, props: true },
  ]

})
