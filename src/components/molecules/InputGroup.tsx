import { forwardRef, Ref } from 'react'
import cls from 'classnames'
import Label, { TLabel } from '../atoms/Label'
import { Input, TInput } from '../atoms/Input'

export type TInputGroup = TInput & {
    id: string
    label: string
    hiddenLabel?: boolean
    className?: string
    errorMessage?: string
    successMessage?: string
    required?: boolean
}

const InputGroup = forwardRef<HTMLInputElement, TInputGroup>(
    (
        {
            id,
            label,
            hiddenLabel = false,
            className,
            errorMessage,
            successMessage,
            required = false,
            error,
            success,
            warning,
            ...inputProps
        },
        ref,
    ) => {
        const hasValidationMessage = !!(errorMessage || successMessage)
        const validationMessage = errorMessage || successMessage || ''
        const validationStyles = cls({
            'text-red-500': errorMessage,
            'text-green-500': successMessage,
        })

        return (
            <div className={cls('flex flex-col gap-2', className)}>
                <Label text={label} htmlFor={id} hiddenLabel={hiddenLabel} />
                <Input
                    id={id}
                    ref={ref}
                    error={
                        errorMessage !== undefined &&
                        errorMessage !== null &&
                        errorMessage !== ''
                    }
                    success={
                        successMessage !== undefined &&
                        successMessage !== null &&
                        successMessage !== ''
                    }
                    required={required}
                    {...inputProps}
                />
                {hasValidationMessage && (
                    <span className={cls('text-sm', validationStyles)}>
                        {validationMessage}
                    </span>
                )}
            </div>
        )
    },
)

export default InputGroup
