import { defineClientConfig } from '@vuepress/client'
import apiTester from './components/api-tester.vue'

import hljsVuePlugin from "@highlightjs/vue-plugin";
import 'highlight.js/styles/stackoverflow-light.css'
import hljs from 'highlight.js/lib/core';
import json from 'highlight.js/lib/languages/json';

hljs.registerLanguage('json', json);

export default defineClientConfig({
  enhance({ app, router, siteData }) {
    app.use(hljsVuePlugin);
    app.component('api-tester', apiTester);
  },
  setup() {},
  rootComponents: [],
})