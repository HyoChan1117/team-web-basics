// src/lib/api.js
import axios from "axios";

export const api = axios.create({
  baseURL: import.meta.env.DEV ? "/api" : import.meta.env.VITE_API_BASE_URL, // 예: PHP 서버
  headers: { "Content-Type": "application/json" },
  withCredentials: false, // 세션을 쓸 경우 true
});

/**
 * 공통 에러 추출 헬퍼
 * @param {any} e - Axios 또는 일반 에러 객체
 * @returns {string} 에러 메시지
 */
export function extractError(e) {
  if (axios.isAxiosError(e)) {
    const data = e.response?.data;
    if (data?.error) return data.error;
    return e.message;
  }
  return "알 수 없는 오류";
}
