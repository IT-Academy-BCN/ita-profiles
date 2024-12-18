import { useNavigate } from 'react-router-dom'
import axios from 'axios'
import React, { useState } from 'react'
import { SubmitHandler, useForm } from 'react-hook-form'
import { z } from 'zod'
import { zodResolver } from '@hookform/resolvers/zod'
import { LoginUserSchema } from '../../schemes/schemas'
import { TLoginForm, TUserResponseData } from '../../../types'
import { Button } from "../atoms/Button";
import { useLogin } from '../../context/LoginContext'
import Modal from '../molecules/Modal'

const openRegisterButtonStyles = 'mt-10 cursor-pointer font-bold underline decoration-solid'

type LoginPopupProps = {
  onClose: () => void
  onOpenRegisterPopup: () => void
  user: TUserResponseData,
  isOpen: boolean
}

type TFormSchema = z.infer<typeof LoginUserSchema>

const LoginPopup: React.FC<LoginPopupProps> = ({
  onClose,
  onOpenRegisterPopup,
  user,
  isOpen
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
      setCustomError('El usuario o la contraseña son incorrectos.');
    }
  }

  return (
    <Modal isOpen={isOpen} onClose={onClose} >
      <div
        role="dialog"
        className="flex flex-col items-center rounded-lg px-24 py-16 md:px-36">
        <h2 className="text-xl font-bold text-black-3 mb-4">Login</h2>
        <form className="flex flex-col" onSubmit={handleSubmit(handleLogin)}>
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
          <p className="text-error py-2">{customError}</p>
        )}        
        <div          
          aria-labelledby="Cambiar o recuperar contraseña"
          className="mb-8 mt-2 text-right text-sm cursor-pointer underline decoration-solid"
        >
          Recordar/cambiar contraseña
        </div>
        <Button type='submit'>Login</Button>
      </form>
      <Button
        defaultButton={false}
        className={openRegisterButtonStyles}
        onClick={onOpenRegisterPopup}
      >
        ¿No tienes cuenta? crear una
      </Button>
      </div>
    </Modal>
  )
}

export default LoginPopup
