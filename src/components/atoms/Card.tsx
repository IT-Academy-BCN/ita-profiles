import { HTMLAttributes, FC } from 'react'
import cls from 'classnames'

const defaultCardStyles = 'bg-white px-4 py-2 rounded'
const secondaryCardStyles = 'cursor-pointer'

type TCard = HTMLAttributes<HTMLDivElement> & {
  secondary?: boolean
};

export const Card: FC<TCard> = ({
  secondary = false,
  className,
  children,
}) => {
  return (
    <div 
      className={cls(
        defaultCardStyles,
        secondary && secondaryCardStyles,
        className,
      )}
    >
      {children}
    </div>
  )
}
