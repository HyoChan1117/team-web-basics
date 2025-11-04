import { createRouter, createWebHistory } from 'vue-router'

import StudentsList from '@/views/StudentsList.vue'
import StudentCreate from '@/views/StudentCreate.vue'
import StudentDetail from '@/views/StudentDetail.vue'
import StudentEdit from '@/views/StudentEdit.vue'
import StudentDelete from '@/views/StudentDelete.vue'

export default createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', component: StudentsList },
    { path: '/students/create', component: StudentCreate },
    { path: '/students/:std_id', component: StudentDetail, props: true },
    { path: '/students/:std_id/edit', component: StudentEdit, props: true },
    { path: '/students/:std_id/delete', component: StudentDelete, props: true },
  ],
})
