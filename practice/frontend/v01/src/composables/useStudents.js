// src/composables/useStudents.js
import { ref } from "vue";
import { extractError } from "../lib/api.js";
import { fetchStudents, fetchStudent, createStudent, updateStudent, deleteStudent } from "../services/studentsApi.js";

/**
 * 학생 관련 상태와 CRUD 함수를 제공하는 composable
 */
export function useStudents() {
  const list = ref([]);           // 학생 목록
  const detail = ref(null);       // 선택된 학생 상세
  const loading = ref(false);     // 로딩 상태
  const error = ref(null);        // 에러 메시지

  /**
   * 전체 학생 목록 불러오기
   */
  async function loadList() {
    loading.value = true;
    error.value = null;
    try {
      list.value = await fetchStudents();
    } catch (e) {
      error.value = extractError(e);
    } finally {
      loading.value = false;
    }
  }

  /**
   * 특정 학생 상세 불러오기
   * @param {string|number} std_id
   */
  async function loadOne(std_id) {
    loading.value = true;
    error.value = null;
    try {
      detail.value = await fetchStudent(std_id);
    } catch (e) {
      error.value = extractError(e);
      detail.value = null;
    } finally {
      loading.value = false;
    }
  }

  /**
   * 새 학생 등록
   * @param {Object} payload - 학생 생성 입력 데이터
   */
  async function createOne(payload) {
    loading.value = true;
    error.value = null;
    try {
      const created = await createStudent(payload);
      list.value.unshift(created); // 목록에 바로 반영
      return created;
    } catch (e) {
      error.value = extractError(e);
      throw e;
    } finally {
      loading.value = false;
    }
  }

  /**
   * 학생 정보 수정
   * @param {string|number} std_id
   * @param {Object} payload
   */
  async function updateOne(std_id, payload) {
    loading.value = true;
    error.value = null;
    try {
      await updateStudent(std_id, payload);
      const idx = list.value.findIndex(s => s.std_id == String(std_id));
      if (idx !== -1) list.value[idx] = { ...list.value[idx], ...payload };
      if (detail.value && detail.value.std_id == String(std_id)) {
        detail.value = { ...detail.value, ...payload };
      }
    } catch (e) {
      error.value = extractError(e);
      throw e;
    } finally {
      loading.value = false;
    }
  }

  /**
   * 학생 삭제
   * @param {string|number} std_id
   */
  async function removeOne(std_id) {
    loading.value = true;
    error.value = null;
    try {
      await deleteStudent(std_id);
      list.value = list.value.filter(s => s.std_id != String(std_id));
      if (detail.value?.std_id == String(std_id)) {
        detail.value = null;
      }
    } catch (e) {
      error.value = extractError(e);
      throw e;
    } finally {
      loading.value = false;
    }
  }

  return {
    list,
    detail,
    loading,
    error,
    loadList,
    loadOne,
    createOne,
    updateOne,
    removeOne
  };
}
