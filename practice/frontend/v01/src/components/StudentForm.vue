<!-- src/components/StudentForm.vue -->
<script setup>
import { reactive } from "vue";

/**
 * @typedef {"create" | "edit"} Mode
 * @typedef {Object} Student
 * @property {string} std_id
 * @property {string} email
 * @property {string} name
 * @property {string} birth
 * @property {string} gender
 * @property {number} [admission_year]
 * @property {number} [current_year]
 * @property {string} [status]
 */

/**
 * @typedef {Object} StudentCreateInput
 * @property {string} std_id
 * @property {string} email
 * @property {string} password
 * @property {string} name
 * @property {string} birth
 * @property {string} gender
 * @property {number} [admission_year]
 * @property {number} [current_year]
 * @property {string} [status]
 */

/**
 * @typedef {Partial<Omit<StudentCreateInput, "std_id" | "password">> & { password?: string }} StudentUpdateInput
 */

const props = defineProps({
  mode: { type: String, required: true },
  initial: { type: Object, default: () => ({}) },
});

const emit = defineEmits(["submit"]);

const form = reactive({
  std_id: props.initial?.std_id ?? "",
  email: props.initial?.email ?? "",
  password: "",
  name: props.initial?.name ?? "",
  birth: props.initial?.birth ?? "",
  gender: props.initial?.gender ?? "",
  admission_year: props.initial?.admission_year ?? undefined,
  current_year: props.initial?.current_year ?? undefined,
  status: props.initial?.status ?? "재학",
});

function onSubmit() {
  if (props.mode === "create") {
    const payload = {
      std_id: String(form.std_id).trim(),
      email: form.email.trim(),
      password: form.password,
      name: form.name.trim(),
      birth: form.birth.trim(),
      gender: form.gender.trim(),
      admission_year: form.admission_year ? Number(form.admission_year) : undefined,
      current_year: form.current_year ? Number(form.current_year) : undefined,
      status: form.status,
    };
    emit("submit", payload);
  } else {
    const payload = {
      email: form.email?.trim(),
      name: form.name?.trim(),
      birth: form.birth?.trim(),
      gender: form.gender?.trim(),
      admission_year: form.admission_year ? Number(form.admission_year) : undefined,
      current_year: form.current_year ? Number(form.current_year) : undefined,
      status: form.status,
    };
    emit("submit", payload);
  }
}
</script>

<template>
  <form class="space-y-3" @submit.prevent="onSubmit">
    <div v-if="mode === 'create'">
      <label class="block text-sm">std_id</label>
      <input v-model="form.std_id" class="border p-2 w-full" required />
    </div>

    <div>
      <label class="block text-sm">email</label>
      <input type="email" v-model="form.email" class="border p-2 w-full" required />
    </div>

    <div v-if="mode === 'create'">
      <label class="block text-sm">password</label>
      <input type="password" v-model="form.password" class="border p-2 w-full" required />
    </div>

    <div>
      <label class="block text-sm">name</label>
      <input v-model="form.name" class="border p-2 w-full" required />
    </div>

    <div>
      <label class="block text-sm">birth (YYYY-MM-DD)</label>
      <input v-model="form.birth" class="border p-2 w-full" required />
    </div>

    <div>
      <label class="block text-sm">gender</label>
      <input v-model="form.gender" class="border p-2 w-full" required />
    </div>

    <div class="grid grid-cols-2 gap-3">
      <div>
        <label class="block text-sm">admission_year</label>
        <input type="number" v-model.number="form.admission_year" class="border p-2 w-full" />
      </div>
      <div>
        <label class="block text-sm">current_year</label>
        <input type="number" v-model.number="form.current_year" class="border p-2 w-full" />
      </div>
    </div>

    <div>
      <label class="block text-sm">status</label>
      <input v-model="form.status" class="border p-2 w-full" />
    </div>

    <button class="bg-black text-white px-4 py-2 rounded">
      {{ mode === "create" ? "등록" : "수정" }}
    </button>
  </form>
</template>
