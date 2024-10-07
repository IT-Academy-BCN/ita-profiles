import { useContext, useEffect } from 'react'
import { ThemeContext } from '../context/ThemeContext'
import type { ThemeContextT } from '../context/ThemeContext'

const SwitchTheme: React.FC = () => {
    // Accesses the themeContext to get the theme and setTheme function
    const themeContext = useContext<ThemeContextT>(ThemeContext)
    const { theme, setTheme } = themeContext

    useEffect(() => {
        if (theme === 'dark') {
            // Adds the "dark" class if the theme is dark
            document.documentElement.classList.add('dark')
        } else {
            // Removes the "dark" class if the theme isn't dark

            document.documentElement.classList.remove('dark')
        }
    }, [theme])
    // Toggles the theme between "light" and "dark"
    const handleThemeToggle = () => {
        setTheme(theme === 'light' ? 'dark' : 'light')
    }

    return (
        <>
            <input
                type="checkbox"
                className="toggle toggle-lg"
                checked={theme === 'dark'}
                onChange={handleThemeToggle}
            />

            <p className="font font-extrabold">PRUEBA DE CAMBIO DE COLOR:</p>
            <p className="text-red-500 dark:text-blue-500">
                LIGHT = RED y DARK = BLUE
            </p>
        </>
    )
}

export default SwitchTheme
