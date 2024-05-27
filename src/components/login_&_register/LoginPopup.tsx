import axios from 'axios'
import React from 'react'
import { SubmitHandler, useForm } from 'react-hook-form'
import { ILoginForm } from '../../interfaces/interfaces'

type LoginPopupProps = {
  onClose: () => void
}

const LoginPopup: React.FC<LoginPopupProps> = ({ onClose }) => {
  const { handleSubmit, register } = useForm<ILoginForm>()
  const handleLogin: SubmitHandler<ILoginForm> = async (data) => {
    try {
      const response = await axios.post('http://localhost:3000/login', data)
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
    <div className="w-1/3 relative flex flex-col items-center rounded-lg bg-white p-5 md:p-20">
      <h2 className="text-lg font-bold text-black-3">Login</h2>
      <form className="flex flex-col space-y-4">
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
          className="border-gray-300 w-full rounded-lg border p-4 px-4 py-4 focus:border-blue-300 focus:outline-none focus:ring"
          placeholder="email por ahora."
          {...register('email')}
        />
        <input
          type="password"
          id="password"
          className="border-gray-300 w-full rounded-lg border p-4 px-4 py-4 focus:border-blue-300 focus:outline-none focus:ring"
          placeholder="Contraseña"
          {...register('password')}
        />
        <div className="mt-4 text-center">
          <button
            type="button"
            className="cursor-pointer text-black-2"
            style={{ textDecoration: 'underline' }}
          >
            Recordar/cambiar contraseña
          </button>
        </div>
        <button
          type="button"
          className="h-12 w-full rounded-lg bg-pink-500 font-bold text-white"
          onClick={handleSubmit(handleLogin)}
        >
          Login
        </button>
      </form>
      <div className="mt-4 text-center">
        <button
          type="button"
          className="cursor-pointer font-bold text-black-2"
          style={{ textDecoration: 'underline' }}
        >
          ¿No tienes cuenta? crear una
        </button>
      </div>
    </div>
  )
}

export default LoginPopup
