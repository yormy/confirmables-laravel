import { defineConfig } from 'vitepress'

export default defineConfig({
  title: "Confirmables",
  description: "",
  base: '/confirmables-laravel/',
  head: [
    ['link', { rel: "apple-touch-icon", sizes: "180x180", href: "/assets/images/apple-touch-icon.png"}],
    ['link', { rel: "icon", type: "image/png", sizes: "32x32", href: "/assets/images/favicon-32x32.png"}],
    ['link', { rel: "icon", type: "image/png", sizes: "16x16", href: "/assets/images/favicon-16x16.png"}],
  ],
  themeConfig: {
    search: {
      provider: 'local'
    },
    nav: [
      { text: 'Home', link: '/' },
      { text: 'Guide', link: '/v1/introduction/what-is-confirmables' },
    ],

    sidebar: [
      {
        text: 'Introduction',
        items: [
          { text: 'What is Chaski', link: '/v1/introduction/what-is-confirmables' },
          { text: 'Definitions', link: '/v1/definitions.md' },
          { text: 'Need Support?', link: '/general/support/support-me' },
        ]
      },
      {
        text: 'Getting Started',
        items: [
          { text: 'Installation', link: '/v1/guide/installation' },
          { text: 'Basic Setup', link: '/v1/guide/basic/setup' },
          { text: 'Basic Configuration', link: '/v1//guide/basic/configuration' },
          { text: 'Frontend', link: '/v1//guide/basic/frontend' },
        ]
      },
      {
        text: 'Notification creations',
        items: [
          { text: 'read mailtracking -todo', link: '/v1/guide/advanced/setup/routes' },
        ]
      },
      {
        text: 'Mail Tracking Setup',
        items: [
          { text: 'read mailtracking -todo', link: '/v1/guide/advanced/setup/routes' },
          { text: 'Encryption - todo', link: '/v1/guide/advanced/setup/routes' },
        ]
      },
      {
        text: 'Subscription managment',
        items: [
          { text: 'read  -todo', link: '/v1/guide/advanced/setup/routes' },
        ]
      },

      {
        text: 'Advanced Setup',
        items: [
          { text: 'Remove Chaskis on Routes', link: '/v1/guide/advanced/setup/routes' },
        ]
      },
      {
        text: 'Advanced Configuration',
        items: [
          { text: 'Config files', link: '/v1/guide/advanced/configuration/config-files' },
        ]
      },
      {
        text: 'General Customization',
        items: [
          { text: 'Publish Config', link: '/v1/guide/customization/config' },
          { text: 'Translations', link: '/v1/guide/customization/translations' },
          { text: 'Database', link: '/v1/guide/customization/database' },
          { text: 'Service Helpers', link: '/v1/guide/customization/services' },
        ]
      },
      {
        text: 'Wire Customization',
        items: [
          { text: 'Wires', link: '/v1/guide/customization/wires' },
        ]
      },
      {
        text: 'References',
        items: [
          {
            text: 'Wires',
            items: [
              { text: 'Request', link: '/v1/guide/references/wires-request' }
            ]
          },
          { text: 'Events', link: '/v1/guide/references/events' },
          { text: 'All Wires', link: '/v1/guide/references/wires' },
          { text: 'Regex for wires', link: '/v1/guide/references/wires/regex' },
          { text: 'Response Types', items: [
              { text: 'Json Response', link: '/v1/guide/references/json-response' },
              { text: 'Html Response', link: '/v1/guide/references/html-response' },
            ]},
        ]
      },
      { text: 'Contributing', items: [
        { text: 'Report Security Issues', link: '/general/report_security' },
        { text: 'Roadmap', link: '/general/roadmap' },
        { text: 'License', link: '/general/license' },
        { text: 'Change log', link: '/general/changelog' },
        { text: 'Contributing', link: '/general/contributing' },
        { text: 'Code of Conduct', link: '/general/code_of_conduct' },
        { text: 'Credits', link: '/general/credits' },
      ]},

      { text: 'Contact', items: [
          { text: 'Contact', link: '/general/contact' },
          { text: 'Support', link: '/general/support/support-me' },
          { text: 'Donations', link: '/general/support/donations' },
        ]},

    ],

    footer: {
      message: 'Released under the MIT License.',
      copyright: 'Copyright © 2022 to present Yormy'
    },
    socialLinks: [
      { icon: 'github', link: 'https://github.com/yormy/confirmables-laravel' }
    ]
  }
})
