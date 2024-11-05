import { useEffect, useState } from 'react'

type SuccessProps = { message: string }
export const Success: React.FC<SuccessProps> = ({ message }) => {
    const [isVisible, setIsVisible] = useState(true)

    useEffect(() => {
        const timer = setTimeout(() => {
            setIsVisible(false)
        }, 3000) 
        return () => clearTimeout(timer)
    }, [])

    if (!isVisible) return null
    return (
        <div role="alert" className="alert alert-success mb-4">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                className="h-6 w-6 shrink-0 stroke-current"
                fill="none"
                viewBox="0 0 24 24"
            >
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            </svg>
            <span>{message}</span>
        </div>
    )
}
