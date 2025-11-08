// src/api/client.js
import axios from 'axios'

// Vite dev 서버 프록시 사용 → 프론트에서는 항상 '/api'만 호출
const BASE_URL = '/api'

export const api = axios.create({
  baseURL: BASE_URL,
  headers: { 'Content-Type': 'application/json' },
  timeout: 10000,
})

// // 응답 인터셉터: 실패 시 에러 객체에 status/body를 담아서 throw
// api.interceptors.response.use(
//   (res) => res,
//   (error) => {
//     const r = error?.response
//     const err = new Error(`[API] ${r?.config?.method?.toUpperCase()} ${r?.config?.url} ${r?.status}`)
//     err.status = r?.status
//     err.body = r?.data ?? r?.statusText ?? null  // ← 서버의 유효성 오류 JSON 그대로
//     console.error('[API ERROR]', err.message, err.body)
//     throw err
//   }
// )

// 공통 request 헬퍼 (성공 시 data만 반환)
export async function request(method, url, data) {
  const res = await api.request({ method, url, data })
  return res.data
}
