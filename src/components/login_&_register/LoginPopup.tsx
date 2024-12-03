import { useNavigate } from 'react-router-dom'
import axios from 'axios'
import React, { useState } from 'react'
import { SubmitHandler, useForm } from 'react-hook-form'
import { z } from 'zod'
import { zodResolver } from '@hookform/resolvers/zod'
import { LoginUserSchema } from '../../schemes/schemas'
import { TLoginForm, TUserResponseData } from '../../../types'
import { useLogin } from '../../context/LoginContext'

type LoginPopupProps = {
  onClose: () => void
  onOpenRegisterPopup: () => void
  user: TUserResponseData
}

type TFormSchema = z.infer<typeof LoginUserSchema>

const LoginPopup: React.FC<LoginPopupProps> = ({
  onClose,
  onOpenRegisterPopup,
  user
}) => {

  const { login } = useLogin();
  const navigate = useNavigate();
  const [customError, setCustomError] = useState<string | null>(null);
  const { handleSubmit, register, formState: { errors }, } = useForm<TFormSchema>({ resolver: zodResolver(LoginUserSchema) })
  const handleLogin: SubmitHandler<TLoginForm> = async (data) => {
    try {
      const response = await axios.post('//localhost:8000/api/v1/signin', data)
      // eslint-disable-next-line
      user = response.data
      login(user);
      onClose()
      navigate('/profile')
    } catch (e) {
      setCustomError('El usuario o la contraseña son incorrectos.'); // Set custom error message
    }
  }

  return (
    <div className=" relative flex flex-col items-center rounded-lg bg-white px-24 py-16 md:px-36">
      <h2 className="text-xl font-bold text-black-3 mb-4">Login</h2>
      <form className="flex flex-col">
        <button
          type="button"
          className="absolute right-2 top-2 h-8 w-8 cursor-pointer rounded-full border-none bg-transparent"
          onClick={onClose}
        >
          ✕
        </button>
        <input
          type="text"
          id="dni"
          className="border-gray-300 w-full rounded-lg border p-4 my-2 focus:border-blue-300 focus:outline-none focus:ring"
          placeholder="DNI o NIE"
          {...register('dni')}
        />
        {errors.dni && (
          <p className="text-error">{`${errors.dni?.message}`}</p>
        )}
        <input
          type="password"
          id="password"
          className="border-gray-300 w-full rounded-lg border p-4 my-2 focus:border-blue-300 focus:outline-none focus:ring"
          placeholder="Contraseña"
          {...register('password')}
        />
        {errors.password && (
          <p className="text-error">{`${errors.password?.message}`}</p>
        )}

        {customError && (
          <p className="text-error py-2">{customError}</p> // Display custom error message
        )}

        <div className="ml-16 mb-4 mt-2 text-center text-sm">
          <button
            type="button"
            className="cursor-pointer"
            style={{ textDecoration: 'underline' }}
          >
            Recordar/cambiar contraseña
          </button>
        </div>
        <button
          // type="submit"
          type="button"
          className="h-12 w-full my-4 rounded-lg bg-primary font-bold text-white"
          onClick={handleSubmit(handleLogin)}
        >
          Login
        </button>
      </form>
      <div className="mt-4 text-center">
        <button
          type="button"
          className="cursor-pointer font-bold"
          style={{ textDecoration: 'underline' }}
          onClick={onOpenRegisterPopup}
        >
          ¿No tienes cuenta? crear una
        </button>
      </div>
    </div>
  )
}

export default LoginPopup
