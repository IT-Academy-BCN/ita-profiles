import { ButtonHTMLAttributes, FC } from 'react'
import cls from 'classnames'

const defaultButtonStyles =
    'cursor-pointer flex-1 py-4 rounded-xl font-bold text-[rgba(128,128,128,1)] border border-[rgba(128,128,128,1)]'
const secondaryBg = 'bg-secondary text-white'
const primaryBg = 'bg-primary text-white'
// Add here outline and other default styles ...

type TButton = ButtonHTMLAttributes<HTMLButtonElement> & {
    secondary?: boolean
    primary?: boolean
}

export const Button: FC<TButton> = ({
    type = 'button',
    secondary = false,
    primary = false,
    className,
    ...rest
}) => (
    <button
        // eslint-disable-next-line react/button-has-type
        type={type}
        className={cls(
            defaultButtonStyles,
            secondary && secondaryBg,
            primary && primaryBg,
            className,
        )}
        {...rest}
    >
        {rest.children}
    </button>
)
