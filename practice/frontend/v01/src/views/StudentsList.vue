<script setup>
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useStudentsStore } from '@/stores/students'
import StudentTable from '@/components/StudentTable.vue'

const s = useStudentsStore()
const router = useRouter()

onMounted(() => s.fetchList())

const go = (path) => router.push(path)
</script>

<template>
  <div>
    <br>
    
    <StudentTable
      :rows="s.list"
      :loading="s.loading"
      @view="id => go('/students/' + id)"
      @edit="id => go('/students/' + id + '/edit')"
      @remove="s.removeById"
    />
  </div>
</template>
