module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
theme: {
  extend: {
    typography: (theme) => ({
      DEFAULT: {
        css: {
          h1: { fontSize: theme('fontSize.3xl') },
          h2: { fontSize: theme('fontSize.2xl') },
          p: { marginBottom: '1rem' },
        },
      },
    }),
  },
},
  plugins: [
    require('@tailwindcss/typography'),
  ],
}