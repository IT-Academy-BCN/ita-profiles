import { useContext, useEffect } from 'react'
import { ThemeContext } from '../context/ThemeContext'
import type { ThemeContextT } from '../context/ThemeContext'

const SwitchTheme: React.FC = () => {
    const { theme, setTheme } = useContext<ThemeContextT>(ThemeContext)

    useEffect(() => {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    }, [theme])

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
