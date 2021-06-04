module.exports = {
  purge: [
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      boxShadow: {
        'icon': 'rgba(6 78 59) 0 0 2px'
      },
      gridTemplateColumns: {
        'sidebar': '2rem auto',
        'dictionary': 'repeat(2, minmax(0, 1fr))',
        'gallery': 'repeat(3, minmax(0, 1fr))',
        'detail': 'repeat(5, minmax(0, 1fr))'
      },
      textColor: {
        'primary' : '#2F6439',
        'secondary': '#d17732',
        'linky': '#1046CB',
        'standart': '#0E2210'
      },
    },
    
  },
  variants: {
    extend: {
      alignItems: ['hover'],
      backgroundColor: ['active'],
      display: ['group-hover'],
      gridTemplateColumns: ['group-hover'],
      width: ['hover'],
    },
    
  },
  plugins: [],
}
