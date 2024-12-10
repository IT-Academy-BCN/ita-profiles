import { FC } from 'react'
import { TCard } from '../../../types'

const defaultCardStyles = 'bg-white px-4 py-2 rounded'

export const Card: FC<TCard> = ({
  styles = defaultCardStyles,
  children,
  handleClick,
  handleKeyDown,
}) => {
  return (
    <div 
    className={styles}
    role='button' 
    onClick={handleClick}
    onKeyDown={handleKeyDown}
    tabIndex={0}>
      {children}
    </div>
  )
}
