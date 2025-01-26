import { zodResolver } from '@hookform/resolvers/zod'
import axios from 'axios'
import React, { useState } from 'react'
import { SubmitHandler, useForm } from 'react-hook-form'
import { z } from 'zod'
import { UserSchema } from '../../schemes/schemas'
import Modal from '../molecules/Modal'

type RegisterPopupProps = {
    onClose: () => void
    onOpenLoginPopup: () => void
    isOpen: boolean
}

type TFormSchema = z.infer<typeof UserSchema>

const RegisterPopup: React.FC<RegisterPopupProps> = ({
    onClose,
    onOpenLoginPopup,
    isOpen,
}) => {
    const [isChecked, setIsChecked] = useState(false)
    const [checkError, setCheckError] = useState(false)

    const {
        register,
        handleSubmit,
        reset,
        formState: { errors },
    } = useForm<TFormSchema>({ resolver: zodResolver(UserSchema) })

    const sendRegister: SubmitHandler<TFormSchema> = async (data) => {
        try {
            if (isChecked) {
                // This creates a user in db.json.
                const response = await axios.post(
                    'http://localhost:8000/users/register',
                    data,
                )
                // eslint-disable-next-line no-console
                console.log('response de register =>', response.data)
                reset()
                onClose()
            } else {
                setCheckError(true)
            }
        } catch (error) {
            // eslint-disable-next-line no-console
            console.log(error)
        }
    }

    const inputStyle =
        'border-gray-300 w-full h-12 p-2 px-4 py-4 md:p-4 md:px-6 md:py-2 border rounded-lg focus:border-blue-300 focus:outline-none focus:ring mb-2'
    const textError = 'text-error'
    const textErrorStyle = `${textError}  break-words max-w-[244px]`

    return (
        <Modal isOpen={isOpen} onClose={onClose}>
            <div className="w-120 flex flex-col items-center rounded-xl p-5 pt-2 md:p-20 md:pt-10 h-auto max-h-[580px] overflow-y-auto">
                <h2 className="text-lg font-bold md:text-2xl mb-3 md:mb-20">
                    Registro
                </h2>
                <form className="flex flex-col space-y-4">
                    <div className="grid grid-cols-2 gap-4">
                        <div>
                            <input
                                {...register('dni')}
                                type="text"
                                id="dni"
                                className={inputStyle}
                                placeholder="DNI o NIE"
                            />
                            {errors.dni && (
                                <p
                                    className={textErrorStyle}
                                >{`${errors.dni?.message}`}</p>
                            )}
                        </div>
                        <div>
                            <input
                                {...register('email')}
                                type="email"
                                id="email"
                                className={inputStyle}
                                placeholder="Email"
                            />
                            {errors.email && (
                                <p
                                    className={textErrorStyle}
                                >{`${errors.email?.message}`}</p>
                            )}
                        </div>
                        <div>
                            <input
                                {...register('username')}
                                type="text"
                                id="username"
                                className={inputStyle}
                                placeholder="Username"
                            />
                            {errors.username && (
                                <p
                                    className={textErrorStyle}
                                >{`${errors.username?.message}`}</p>
                            )}
                        </div>

                        <div>
                            <input
                                type="text"
                                {...register('specialization')}
                                id="specialization"
                                className={inputStyle}
                                placeholder="Specialization"
                            />
                            {errors.specialization && (
                                <p
                                    className={textErrorStyle}
                                >{`${errors.specialization.message}`}</p>
                            )}
                        </div>

                        <div>
                            <input
                                {...register('password')}
                                type="password"
                                id="password"
                                className={inputStyle}
                                placeholder="Password"
                            />
                            {errors.password && (
                                <p
                                    className={textErrorStyle}
                                >{`${errors.password?.message}`}</p>
                            )}
                        </div>
                        <div>
                            <input
                                type="password"
                                {...register('confirmPassword')}
                                id="confirmPassword"
                                className={inputStyle}
                                placeholder="Confirm Password"
                            />
                            {errors.confirmPassword && (
                                <p
                                    className={textErrorStyle}
                                >{`${errors.confirmPassword?.message}`}</p>
                            )}
                        </div>
                    </div>

                    <div className="flex items-center justify-center space-x-8 p-4 md:p-5 ">
                        <div className="flex flex-col">
                            <div className="flex items-center gap-1">
                                <input
                                    type="checkbox"
                                    id="acceptTerms"
                                    className="h-5 w-5"
                                    checked={isChecked}
                                    onChange={(e) =>
                                        setIsChecked(e.target.checked)
                                    }
                                />
                                <label
                                    htmlFor="acceptTerms"
                                    className=" mr-2 text-sm"
                                >
                                    Acepto{' '}
                                    <span
                                        style={{ textDecoration: 'underline' }}
                                    >
                                        términos legales
                                    </span>
                                </label>
                            </div>
                            {checkError && (
                                <p
                                    className={`${
                                        isChecked ? 'hidden' : 'text-error'
                                    }`}
                                >
                                    Debes aceptar los términos
                                </p>
                            )}
                        </div>
                        <button
                            type="button"
                            className="w-102 mr-6 h-12 cursor-pointer rounded-lg border-none bg-primary text-white md:h-12 md:w-60 md:text-lg"
                            onClick={handleSubmit(sendRegister)}
                        >
                            Register
                        </button>
                    </div>
                </form>
                <div className="mt-4 text-center">
                    <button
                        type="button"
                        onClick={onOpenLoginPopup}
                        className="cursor-pointer font-bold text-black-2"
                        style={{ textDecoration: 'underline' }}
                    >
                        ¿Tienes cuenta?, acceder
                    </button>
                </div>
            </div>
        </Modal>
    )
}

export default RegisterPopup
