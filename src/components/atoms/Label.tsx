import { FC, LabelHTMLAttributes } from 'react'

export type TLabel = Omit<LabelHTMLAttributes<HTMLLabelElement>, 'htmlFor'> & {
    text: string
    htmlFor: string
    hiddenLabel?: boolean
}

const Label: FC<TLabel> = ({
    htmlFor,
    text = '',
    hiddenLabel = false,
    ...rest
}) => {
    return (
        <label
            htmlFor={htmlFor}
            className={`block text-sm font-medium text-gray-700 ${
                hiddenLabel ? 'sr-only' : ''
            }`}
            {...rest}
        >
            {text}
        </label>
    )
}

export default Label
