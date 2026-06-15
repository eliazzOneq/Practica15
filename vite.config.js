import { defineConfig } from 'vite'
import { visualizer } from 'rollup-plugin-visualizer'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [
    vue(),
    visualizer({
        open: true,
        filename: 'stats.html'
    })
  ],

  server: {
    proxy: {
      '/api': {
        target: 'http://127.0.0.1:8000',
        changeOrigin: true,
      }
    }
  },

  test: {
    environment: 'jsdom',
    globals: true,
  }
})