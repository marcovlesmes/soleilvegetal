module.exports = {
  purge: [
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    textColor: {
      'primary' : '#2F6439',
      'secondary': '#d17732',
      'linky': '#1046CB',
      'standart': '#0E2210'
    },
    boxShadow: {
      'icon': 'rgba(6 78 59) 0 0 2px'
    },
    maxWidth: {
      'sidebar': '3rem'
    },
    container: {
      center: true,

    },
    extend: {},
    
  },
  variants: {
    extend: {
      display: ['group-hover'],
      backgroundColor: ['active'],
    },
    
  },
  plugins: [],
}
