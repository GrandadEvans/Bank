module.exports = {
    // Where are your vue tests located?
    "roots": [
        "<rootDir>/tests/Vue"
    ],
    // vue: transform vue with vue-jest to make jest understand Vue's syntax
    // js: transform js files with babel, we can now use import statements in tests
    "transform": {
        ".*\\.(vue)$": "<rootDir>/node_modules/vue-jest",
        "^.+\\.js$": "<rootDir>/node_modules/babel-jest"
    },
    "collectCoverage": true,
    "collectCoverageFrom": [
        "**/*.{js,vue}",
        "!**/node_modules/**",
        "!**/vendor/**"
    ],

    // (Optional) This file helps you later for global settings
    "setupFilesAfterEnv": [
        // "<rootDir>tests/Vue/setup.js"
    ],
    // (Optional) with that you can import your components like
    // "import Counter from '@/Counter.vue'"
    // (no need for a full path)
    "moduleNameMapper": {
        "^@/(.*)$": "<rootDir>/resources/js/vue/$1"
    },
    "testURL": "http://192.168.0.3:8001",
    "moduleFileExtensions": [
        "js",
        "jsx",
        "vue"
    ],
    "testRegex": "(/__tests__/.*|(\\.|/)(test|spec))\\.(jsx?|tsx?|js?)$",
    "notify": true
}
