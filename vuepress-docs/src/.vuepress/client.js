import { defineClientConfig } from '@vuepress/client'
import apiTester from './components/api-tester.vue'

import 'highlight.js/styles/stackoverflow-light.css'
import hljs from 'highlight.js/lib/core';
import json from 'highlight.js/lib/languages/json';

hljs.registerLanguage('json', json);

export default defineClientConfig({
  async enhance({ app, router, siteData }) {
    if (!__VUEPRESS_SSR__) {
        const hljsVuePlugin = await import('@highlightjs/vue-plugin')
        app.use(hljsVuePlugin.default);
    }
    app.component('api-tester', apiTester);
  },
  setup() {},
  rootComponents: [],
})