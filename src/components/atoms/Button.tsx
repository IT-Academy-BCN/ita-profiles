import { ButtonHTMLAttributes, FC } from 'react'
import cls from 'classnames'

const defaultButtonStyles = 'bg-primary text-white font-bold py-6 w-80 rounded-xl cursor-pointer hover:bg-primary-hover active:bg-primary-active disabled:bg-disabled disabled:cursor-not-allowed'
const outlineButtonStyles = 'bg-white text-stone-500 border border-gray-500 hover:bg-pink-200 hover:border-primary-hover hover:text-primary-hover active:bg-pink-300 active:border-primary active:text-primary-hover disabled:bg-white disabled:text-disabled disabled:border-disabled'
const navbarButtonStyles = 'bg-white text-gray-3 font-medium rounded-lg px-3 py-2 w-auto hover:scale-[1.02] transition duration-150 ease-in-out'

type TButton = ButtonHTMLAttributes<HTMLButtonElement> & {
  defaultButton?: boolean
  outline?: boolean
  navbar?: boolean
}
 
export const Button: FC<TButton> = ({
  type = 'button',
  defaultButton = true,
  outline = false,
  navbar = false,
  className,
  ...rest
}) => (
  <button
    // eslint-disable-next-line react/button-has-type
    type={type}
    className={cls(
      defaultButton && defaultButtonStyles,
      outline && outlineButtonStyles,
      navbar && navbarButtonStyles,
      className,
    )}
    {...rest}
  >
    {rest.children}
  </button>
)
