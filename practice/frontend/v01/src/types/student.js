// src/types/student.js

/**
 * @typedef {Object} Student
 * @property {string} std_id - 백엔드에서 문자열로 전달됨 (숫자여도 문자열로 받아두면 안전)
 * @property {string} email
 * @property {string} name
 * @property {string} birth - "YYYY-MM-DD"
 * @property {string} gender - "M" / "F" 등
 * @property {number} [admission_year]
 * @property {number} [current_year]
 * @property {string} status - "재학" 등
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
 * @description 수정 가능한 필드만 허용. password는 정책에 따라 선택적으로 허용
 */
