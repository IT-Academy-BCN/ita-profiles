import typography from '@tailwindcss/typography'
import daisyui from 'daisyui'

export default {
  content: ['./index.html', './src/**/*.{js,ts,jsx,tsx}'],
  darkMode: 'class',
  theme: {
    extend: {
      // same names as style guidelines on figma
      colors: {
        primary: '#B91879',
        'primary-hover': '#811155',
        'primary-active': '#CE5DA1',
        'black-1': '#000000',
        'black-2': '#1E1E1E',
        'black-3': '#282828', //used in titles
        'gray-1': '#333333',
        'gray-2': '#4F4F4F',
        'gray-3': '#7E7E7E',
        'gray-4-base': '#EBEBEB', //background of the app
        'gray-5-background': '#D9D9D9',
        'ita-wiki': '#3E6990',
        'ita-challenges': '#F29559',
        white: '#FFFFFF',
      },
    },
  },
  daisyui: {
    // https://daisyui.com/docs/colors/
    themes: [
      {
        itacademy: {
          primary: '#B91879',
          'primary-content': '#ffffff',
          'base-content': '#333333',
          secondary: '#F9BB47',
          accent: '#27AE60',
          info: '#2F80ED',
          success: '#27AE60',
          warning: '#E2AA3B',
          error: '#EB5757',
        },
      },
    ],
  },
  plugins: [typography, daisyui],
}
