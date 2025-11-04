// src/api/client.js
import axios from 'axios'

// Vite 프록시를 쓰는 경우 BASE_URL은 '' (빈 문자열)
const BASE_URL = ''

// Axios 인스턴스 생성
const api = axios.create({
  baseURL: BASE_URL,
  headers: {
    'Content-Type': 'application/json',
  },
  // fetch의 no-store 비슷하게, 캐시 방지
  cache: false,
})

// 요청 헬퍼 함수
export async function request(method, path, body) {
  try {
    const response = await api.request({
      url: path,
      method,
      data: body,
    })
    return response.data
  } catch (error) {
    // 서버 응답이 있는 경우
    if (error.response) {
      console.error(
        '[API ERROR]',
        method,
        path,
        error.response.status,
        error.response.data
      )
      const err = new Error('API Error')
      err.status = error.response.status
      err.data = error.response.data
      throw err
    }

    // 네트워크 오류 등
    console.error('[NETWORK ERROR]', method, path, error.message)
    throw error
  }
}
