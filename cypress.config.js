const { defineConfig } = require('cypress')

module.exports = defineConfig({
  projectId: '62a2aj',
  retries: 0,
  defaultCommandTimeout: 8000,
  browser: 'firefox',
  'cypress-watch-and-reload': {
    watch: ['**/*tag*', 'routes/*'],
  },
  e2e: {
    // We've imported your old cypress plugins here.
    // You may want to clean this up later by importing these.
    setupNodeEvents(on, config) {
      return require('./cypress/plugins/index.js')(on, config)
    },
    baseUrl: 'http://192.168.0.3:8001',
    specPattern: 'cypress/e2e/**/*.spec.js',
  },
  component: {
      devServer: {
          framework: 'vue-cli',
          bundler: 'webpack',
      },
      setupNodeEvents(on, config) {},
    specPattern:
      '/home/john/Projects/bank/resources/js/vue/components/**/*.spec.{js,jsx,ts,tsx}',
  },
})
