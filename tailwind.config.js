/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.{html,js,php}"],
  theme: {
    extend: {
      gridTemplateRows: {
        "[auto,auto,1fr]": "auto auto 1fr",
      },
      fontFamily: {
        sans: ["inter", "sans-serif"],
      },
    },
  },
  plugins: [],
};
