import { forwardRef, InputHTMLAttributes } from 'react'
import cls from 'classnames'

export type TInput = InputHTMLAttributes<HTMLInputElement> & {
    error?: boolean | string
    success?: boolean
    warning?: boolean
    type?: 'text' | 'password' | 'email'
    onChange?: (e: React.ChangeEvent<HTMLInputElement>) => void
}

const defaultInputStyles =
    'w-full px-4 py-2 rounded border text-base focus:outline-none border-gray-300'
const successInputStyles = 'border-green-500 focus:ring-green-500'
const warningInputStyles = 'border-yellow-500 focus:ring-yellow-500'
const errorInputStyles = 'border-red-500 focus:ring-red-500'

export const Input = forwardRef<HTMLInputElement, TInput>(
    (
        {
            error = false,
            warning = false,
            success = false,
            type = 'text',
            className,
            onChange,
            ...rest
        },
        ref,
    ) => (
        <input
            type={type}
            className={cls(
                defaultInputStyles,
                success && successInputStyles,
                warning && warningInputStyles,
                error && errorInputStyles,
                className,
            )}
            onChange={onChange}
            aria-invalid={!!error}
            ref={ref}
            {...rest}
        />
    ),
)
