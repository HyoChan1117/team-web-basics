import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
  plugins: [vue()],
  resolve: { alias: { '@': path.resolve(__dirname, './src') } },
  server: {
    proxy: {
      // 백엔드 Nginx가 80에서 서비스 → http://localhost 로 보냄
      '^/(students|health)$': {
        target: 'http://localhost',
        changeOrigin: true,
      },
      // 쿼리 붙는 경우도 커버하려면:
      '/students': {
        target: 'http://localhost',
        changeOrigin: true,
      },
    },
  },
})
