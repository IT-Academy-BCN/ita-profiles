import { createContext, useState } from 'react'
import type {
  TSmallScreenContext,
  TchildrenProps,
} from '../interfaces/interfaces'

export const SmallScreenContext = createContext<TSmallScreenContext>(
  {} as TSmallScreenContext,
)

const SmallScreenProvider = ({ children }: TchildrenProps) => {
  const [isMobile, setIsMobile] = useState(window.innerWidth < 768)

  return (
    // eslint-disable-next-line react/jsx-no-constructed-context-values
    <SmallScreenContext.Provider value={{ isMobile, setIsMobile }}>
      {children}
    </SmallScreenContext.Provider>
  )
}

export default SmallScreenProvider
