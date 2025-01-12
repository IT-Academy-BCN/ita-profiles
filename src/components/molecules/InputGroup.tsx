import { forwardRef, Ref } from 'react'
import cls from 'classnames'
import Label, { TLabel } from '../atoms/Label'
import { Input, TInput } from '../atoms/Input'

export type TInputGroup = TInput & {
    id: string
    label?: string
    hiddenLabel?: boolean
    className?: string
    errorMessage?: string
    successMessage?: string
    warningMessage?: string
    required?: boolean
}

const InputGroup = forwardRef<HTMLInputElement, TInputGroup>(
    (
        {
            id,
            label,
            hiddenLabel,
            className,
            errorMessage,
            successMessage,
            warningMessage,
            required = false,
            error,
            success,
            warning,
            ...inputProps
        },
        ref,
    ) => {
        const hasValidationMessage = !!(
            errorMessage ||
            successMessage ||
            warningMessage
        )
        const validationMessage =
            errorMessage || successMessage || warningMessage || ''
        const validationStyles = cls({
            'text-red-500 bold': errorMessage,
            'text-green-500': successMessage,
            'text-yellow-500': warningMessage,
        })

        return (
            <div className={cls('flex flex-col gap-2', className)}>
                <Label
                    text={label || ''}
                    htmlFor={id}
                    hiddenLabel={hiddenLabel}
                />
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
                    warning={
                        warningMessage !== undefined &&
                        warningMessage !== null &&
                        warningMessage !== ''
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
