/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      './public/index.php',
      './src/views/**/*.{html,php,js}', // Assurez-vous que ce chemin correspond à la structure de votre projet
  ],
  theme: {

    extend: {

        userSelect: {
            'none': 'none',
            'text': 'text',
            'all': 'all',
            'auto': 'auto',
        },

        colors: {
            'primary': {
                '50': '#A0D94A',
                '100': '#81A632',
                '200': '#617320'
            },
            'secondary': {
                '50': '#D9CF48',
                '100': '#D9C14A',
                '200': '#F2A81D',
                '300': '#F28705'
            },
            'accent' :'#F29057',
            'customWhite': '#F2F2E4',
            'customBlack': '#260101'

        },
        fontFamily: {
            heebo: ['Heebo', 'sans-serif'],
            radio: ['"Radio Canada Big"', 'sans-serif'],
            sono: ['Sono', 'sans-serif'],
            vollkorn: ['Vollkorn', 'serif'],
        },

    },
  },
  plugins: [
      require('tailwind-scrollbar'),
  ],
      safelist: [
        'homeHeader',
        'header',
      ],
}

