import { createRouter, createWebHistory } from 'vue-router'
import StudentCreatePage from '../pages/StudentCreatePage.vue'
import StudentDetailPage from '../pages/StudentDetailPage.vue'
import StudentEditPage from '../pages/StudentEditPage.vue'
import StudentTable from '../components/StudentTable.vue'
import { onMounted } from 'vue'
import useStudents from '../composables/useStudents.js'

/** 파일 추가 없이 라우터 안에 간단 리스트 페이지 정의 */
const StudentsListPage = {
  name: 'StudentsListPage',
  components: { StudentTable },
  setup() {
    const s = useStudents()
    onMounted(s.fetchList)
    const go = (path) => window.history.pushState({}, '', path) || router.push(path)
    return { s, go }
  },
  template: `
    <div>
      <StudentTable
        :rows="s.list"
        :loading="s.loading"
        @view="id => go('/students/' + id)"
        @edit="id => go('/students/' + id + '/edit')"
        @remove="s.removeById"
      />
    </div>
  `
}

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', component: StudentsListPage },
    { path: '/students/create', component: StudentCreatePage },
    { path: '/students/:std_id', component: StudentDetailPage, props: true },
    { path: '/students/:std_id/edit', component: StudentEditPage, props: true },
  ],
})

export default router
