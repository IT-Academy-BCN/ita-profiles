import { zodResolver } from '@hookform/resolvers/zod'
import axios from 'axios'
import React, { useState } from 'react'
import { SubmitHandler, useForm } from 'react-hook-form'
import { z } from 'zod'
import { UserSchema } from '../../schemes/schemas'

type RegisterPopupProps = {
    onClose: () => void
    onOpenLoginPopup: () => void
}

type TFormSchema = z.infer<typeof UserSchema>

const RegisterPopup: React.FC<RegisterPopupProps> = ({
    onClose,
    onOpenLoginPopup,
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
                    'http://localhost:3000/users/register',
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

    return (
        <div className="w-120 relative flex flex-col items-center rounded-lg bg-white p-5 md:p-20">
            <h2 className="text-lg font-bold md:text-2xl">Registro</h2>
            <form className="flex flex-col space-y-4">
                <button
                    type="button"
                    className="absolute right-2 top-2 h-8 w-8 cursor-pointer rounded-full border-none bg-transparent"
                    onClick={onClose}
                >
                    ✕
                </button>
                <div className="grid grid-cols-2 gap-4">
                    <div>
                        <input
                            {...register('dni')}
                            type="text"
                            id="dni"
                            className="border-gray-300 w-full rounded-lg border p-2 px-4 py-4 focus:border-blue-300 focus:outline-none focus:ring md:p-4 md:px-6 md:py-2"
                            placeholder="DNI o NIE"
                        />
                        {errors.dni && (
                            <p className="text-error">{`${errors.dni?.message}`}</p>
                        )}
                    </div>
                    <div>
                        <input
                            {...register('username')}
                            type="text"
                            id="username"
                            className="border-gray-300 w-full rounded-lg border p-2 px-4 py-4 focus:border-blue-300 focus:outline-none focus:ring md:p-4 md:px-6 md:py-2"
                            placeholder="Username"
                        />
                        {errors.username && (
                            <p className="text-error">{`${errors.username?.message}`}</p>
                        )}
                    </div>
                </div>
                <div className="grid grid-cols-2 gap-4">
                    <div>
                        <input
                            {...register('password')}
                            type="password"
                            id="password"
                            className="border-gray-300 w-full rounded-lg border p-2 px-4 py-4 focus:border-blue-300 focus:outline-none focus:ring md:p-4 md:px-6 md:py-2"
                            placeholder="Password"
                        />
                        {errors.password && (
                            <p className="text-error">{`${errors.password?.message}`}</p>
                        )}
                    </div>
                    <div>
                        <input
                            {...register('email')}
                            type="email"
                            id="email"
                            className="border-gray-300 w-full rounded-lg border p-2 px-4 py-4 focus:border-blue-300 focus:outline-none focus:ring md:p-4 md:px-6 md:py-2"
                            placeholder="Email"
                        />
                        {errors.email && (
                            <p className="text-error">{`${errors.email?.message}`}</p>
                        )}
                    </div>
                </div>
                <div className="grid grid-cols-2 gap-4">
                    <div>
                        <input
                            type="password"
                            {...register('confirmPassword')}
                            id="confirmPassword"
                            className="border-gray-300 w-full rounded-lg border p-2 px-4 py-4 focus:border-blue-300 focus:outline-none focus:ring md:p-4 md:px-6 md:py-2"
                            placeholder="Confirm Password"
                        />
                        {errors.confirmPassword && (
                            <p className="text-error">{`${errors.confirmPassword?.message}`}</p>
                        )}
                    </div>

                    <div>
                        <input
                            type="text"
                            {...register('specialization')}
                            id="specialization"
                            className="border-gray-300 w-full rounded-lg border p-2 px-4 py-4 focus:border-blue-300 focus:outline-none focus:ring md:p-4 md:px-6 md:py-2"
                            placeholder="Specialization"
                        />
                        {errors.specialization && (
                            <p className="text-error">{`${errors.specialization.message}`}</p>
                        )}
                    </div>
                </div>
                <div className="flex items-center justify-center space-x-8 p-4 md:p-5 ">
                    <div className="flex flex-col">
                        <div className="flex items-center gap-1">
                            <label
                                htmlFor="acceptTerms"
                                className="flex items-center gap-1"
                            >
                                <input
                                    type="checkbox"
                                    id="acceptTerms"
                                    className="h-6 w-6"
                                    checked={isChecked}
                                    onChange={(e) =>
                                        setIsChecked(e.target.checked)
                                    }
                                />
                                Acepto los
                            </label>
                            <a className='underline cursor-pointer'>
                                términos legales
                            </a>
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
                    ¿Tienes cuenta? acceder
                </button>
            </div>
        </div>
    )
}

export default RegisterPopup
