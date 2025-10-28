// src/composables/useTodos.js
import { ref, computed, watch } from 'vue';

const STORAGE_KEY = 'todo-vue-only';

export function useTodos() {
  const todos = ref(load());
  const newTitle = ref('');
  const filter = ref('all'); // 'all' | 'active' | 'completed'

  const remaining = computed(() => todos.value.filter(t => !t.completed).length);
  const completedCount = computed(() => todos.value.filter(t => t.completed).length);

  watch(todos, (val) => save(val), { deep: true });

  function add() {
    const title = newTitle.value.trim();
    if (!title) return;
    todos.value.unshift({
      id: Date.now().toString(36) + Math.random().toString(36).slice(2,6),
      title,
      completed: false
    });
    newTitle.value = '';
  }

  function removeTodo(id) {
    todos.value = todos.value.filter(t => t.id !== id);
  }

  function updateTitle(id, title) {
    const t = todos.value.find(x => x.id === id);
    if (!t) return;
    const text = (title ?? '').trim();
    if (!text) removeTodo(id);
    else t.title = text;
  }

  function toggle(id, done) {
    const t = todos.value.find(x => x.id === id);
    if (t) t.completed = typeof done === 'boolean' ? done : !t.completed;
  }

  function clearCompleted() {
    todos.value = todos.value.filter(t => !t.completed);
  }

  function toggleAll(done) {
    for (const t of todos.value) t.completed = !!done;
  }

  function setFilter(k) {
    filter.value = k;
  }

  function load() {
    try { return JSON.parse(localStorage.getItem(STORAGE_KEY)) ?? []; }
    catch { return []; }
  }
  function save(list) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(list));
  }

  return {
    // state
    todos, newTitle, filter,
    // computed
    remaining, completedCount,
    // actions
    add, removeTodo, updateTitle, toggle, clearCompleted, toggleAll, setFilter,
  };
}
