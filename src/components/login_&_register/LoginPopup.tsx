import axios from 'axios'
import React from 'react'
import { SubmitHandler, useForm } from 'react-hook-form'
import { ILoginForm } from '../../interfaces/interfaces'

type LoginPopupProps = {
  onClose: () => void
  onOpenRegisterPopup: () => void
}

const LoginPopup: React.FC<LoginPopupProps> = ({ 
  onClose,
  onOpenRegisterPopup,
}) => {
  const { handleSubmit, register } = useForm<ILoginForm>()
  const handleLogin: SubmitHandler<ILoginForm> = async (data) => {
    try {
      const response = await axios.post('//localhost:3000/login', data)
      // eslint-disable-next-line no-console
      console.log('El data de login =>', response.data)
      // token se devuelve solo cuando utilizamos email y password.
      // Imposible modificar los campos a dni y password.
      onClose()
    } catch (e) {
      // eslint-disable-next-line no-console
      console.log('el error =>', e)
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
          {...register('email')}
        />
        <input
          type="password"
          id="password"
          className="border-gray-300 w-full rounded-lg border p-4 my-2 focus:border-blue-300 focus:outline-none focus:ring"
          placeholder="Contraseña"
          {...register('password')}
        />
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
