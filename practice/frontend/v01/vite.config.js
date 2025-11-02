import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  server: {
    proxy: {
      // 프론트의 /api/* 요청을 백엔드 nginx(= http://localhost)로 중계
      '/api': {
        target: 'http://localhost',
        changeOrigin: true,
        rewrite: p => p.replace(/^\/api/, ''), // /api/students -> /students
      },
    },
  },
})
