import { ButtonHTMLAttributes, FC } from 'react'
import cls from 'classnames'

const defaultButtonStyles =
  'bg-primary cursor-pointer text-white font-bold py-2 px-4 rounded'
const secondaryButtonStyles = 'bg-secondary'
// Add here outline and other default styles ...

type TButton = ButtonHTMLAttributes<HTMLButtonElement> & {
  secondary?: boolean
}

export const Button: FC<TButton> = ({
  type = 'button',
  secondary = false,
  className,
  ...rest
}) => (
  <button
    // eslint-disable-next-line react/button-has-type
    type={type}
    className={cls(
      defaultButtonStyles,
      secondary && secondaryButtonStyles,
      className,
    )}
    {...rest}
  >
    {rest.children}
  </button>
)
