import { FC, LabelHTMLAttributes } from 'react'
import cls from 'classnames'

const defaultLabelStyles = 'block text-sm font-bold text-gray-2'

export type TLabel = Omit<LabelHTMLAttributes<HTMLLabelElement>, 'htmlFor'> & {
    text: string
    htmlFor: string
    hiddenLabel?: boolean
}

const Label: FC<TLabel> = ({
    htmlFor,
    text = '',
    hiddenLabel = false,
    className,
    ...rest
}) => {
    return (
        <label
            htmlFor={htmlFor}
            className={cls(
                defaultLabelStyles,
                hiddenLabel ? 'sr-only' : '',
                className,
                )}
            {...rest}
        >
            {text}
        </label>
    )
}

export default Label
