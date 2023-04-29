import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import Components from 'unplugin-vue-components/vite';
import viteCompression from 'vite-plugin-compression';
import path from 'path';

export default defineConfig({
  plugins: [
    viteCompression(),
    Components({
      dirs: ['resources/js/components'],
      extensions: ['vue'],
      deep: true,
    }),
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          icludeAbsolute: false,
        },
      },
    }),
  ],
  resolve: {
    alias: {
      '@public': path.resolve(__dirname, './public'),
    },
  },
  build: {
    rollupOptions: {
      output: {
        manualChunks(id) {
          if (id.includes('node_modules')) {
            return id
              .toString()
              .split('node_modules/')[1]
              .split('/')[0]
              .toString();
          }
        },
      },
    },
  },
});
