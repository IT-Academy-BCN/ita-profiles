import { FC, ReactNode, HTMLAttributes } from 'react'

type TTitle = HTMLAttributes<HTMLElement> & {
    children: ReactNode
    as?: 'h1' | 'h2' | 'h3' | 'h4' | 'h5' | 'h6'
}

const Title: FC<TTitle> = ({ children, as = 'h1', ...rest }) => {
    const TitleTag = as
    return <TitleTag {...rest}>{children}</TitleTag>
}

export default Title
