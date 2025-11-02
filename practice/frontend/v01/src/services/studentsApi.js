// src/services/studentsApi.js
import { api } from "../lib/api.js";

/**
 * 모든 학생 목록을 가져옵니다.
 * @returns {Promise<Array>} 학생 배열
 */
export async function fetchStudents() {
  const { data } = await api.get("/students");
  return data;
}

/**
 * 특정 학생을 조회합니다.
 * @param {string|number} std_id - 학생 ID
 * @returns {Promise<Object>} 학생 데이터
 */
export async function fetchStudent(std_id) {
  const { data } = await api.get(`/students/${std_id}`);
  return data;
}

/**
 * 새로운 학생을 등록합니다.
 * @param {Object} input - 학생 생성 입력 데이터
 * @returns {Promise<Object>} 생성된 학생 데이터
 */
export async function createStudent(input) {
  const { data } = await api.post("/students", input);
  return data; // 201 + 생성된 JSON 데이터
}

/**
 * 특정 학생 정보를 수정합니다.
 * @param {string|number} std_id - 학생 ID
 * @param {Object} input - 수정할 필드 데이터
 */
export async function updateStudent(std_id, input) {
  // 백엔드 update는 임의 키를 그대로 SET 하므로, 허용할 필드만 골라 보내는 걸 추천
  await api.patch(`/students/${std_id}`, input);
}

/**
 * 특정 학생을 삭제합니다.
 * @param {string|number} std_id - 학생 ID
 */
export async function deleteStudent(std_id) {
  await api.delete(`/students/${std_id}`);
}
