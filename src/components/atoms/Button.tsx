import { ButtonHTMLAttributes, FC } from 'react'
import cls from 'classnames'

const defaultButtonStyles = 'bg-primary text-white font-bold py-6 px-24 rounded-xl cursor-pointer hover:bg-primary-hover active:bg-primary-active disabled:bg-disabled disabled:cursor-not-allowed'
const outlineButtonStyles = 'bg-white text-stone-500 font-bold py-6 w-80 rounded-xl border border-gray-500 hover:bg-[#EBCDE4] hover:border-[#781555] hover:text-primary-hover active:bg-[#D89CC8] active:border-[#C0559F] active:text-primary-hover disabled:bg-white disabled:text-disabled disabled:border-disabled'
const navbarButtonStyles = 'bg-white text-gray-3 font-medium rounded-lg px-3 py-2 w-auto hover:scale-[1.02] transition duration-150 ease-in-out'
const closeButtonStyles = 'absolute right-6 top-6 cursor-pointer bg-transparent hover:scale-[1.03] transition duration-100 ease-in-out'

type TButton = ButtonHTMLAttributes<HTMLButtonElement> & {
  defaultButton?: boolean
  outline?: boolean
  navbar?: boolean
  close?: boolean
}
 
export const Button: FC<TButton> = ({
  type = 'button',
  defaultButton = true,
  outline = false,
  navbar = false,
  close = false,
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
      close && closeButtonStyles,
      className,
    )}
    {...rest}
  >
    {rest.children}
  </button>
)
