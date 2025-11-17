/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.jsx',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
        colors:{
          bluee: "#52B9CC",
          bluetwo: "#A0D2DB",
          maincolor: "#F2F1ED",
          about:"#2C3E50",
          grey:"#8F8F8F",
          gri:"#D9D9D9"
        },
        backgroundImage:{
         'hero-image':"url('/images/vivid-background.png')",
       //  'hero-image':"url('/images/vivid-background.png')",
          'treatments-image':"url('/images/treatments-background.png')",
          'view-video-image':"url('/images/background.png')",
          'footer-image':"url('/images/Footer.png')"
        },
        screens: {
            xsm: "300px",
            sm: "640px",
            md: "768px",
            lg: "1024px",
            xl: "1280px",
            "2xl": "1536px",
            "3xl": "1700px",
          },

        fontFamily: {
          'fustat': ['Fustat', 'sans-serif'],
        },
      },
  },
  plugins: [],
}

