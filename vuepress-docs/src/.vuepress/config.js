import { defineUserConfig } from 'vuepress'
import { defaultTheme } from '@vuepress/theme-default'

export default defineUserConfig({
  lang: 'en-US',
  title: 'Gond Tools API Documentation',
  description: 'Documentation of the API that powers https://www.gond.tools. The live version is currently running on https://api.uncnso.red/.',
  theme: defaultTheme({
    navbar: [
        {
            text: 'API',
            link: '/api/',
        },
        {
            text: 'Repository',
            link: 'https://github.com/j0Shi82/nwoun-slim-api',
        },
    ],
    sidebar: {
        '/api/': [
            'README.md',
            'auction.md',
            'auth.md',
        ]
    },
    sidebarDepth: 1
  }),
})