import { createContext } from 'react'

export type ThemeContextT = {
  theme: string
  setTheme: (theme: string) => void
}

export const ThemeContext = createContext<ThemeContextT>({
  theme: 'light', // Provide a default theme value
  setTheme: () => {}, // Provide a default setTheme function
})

