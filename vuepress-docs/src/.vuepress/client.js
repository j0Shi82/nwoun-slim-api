import { defineClientConfig } from '@vuepress/client'
import apiTester from './components/api-tester.vue'

export default defineClientConfig({
  enhance({ app, router, siteData }) {
    app.component('api-tester', apiTester)
  },
  setup() {},
  rootComponents: [],
})