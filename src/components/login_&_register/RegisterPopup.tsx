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
const user = {
  dni: '23121527H',
  email: 'userRand02@gmail.com',
  username: 'userRand02',
  specialization: 'Backend',
  password: 'PassPass123!',
  password_confirmation: 'PassPass123!',
  terms: 'true'
}

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
          '//localhost:8000/api/v1/register',
          user
        )
        console.log('data response =>', user);
        // eslint-disable-next-line no-console
        console.log('register response =>', response.data)
        reset()
        onClose()
      } else {
        setCheckError(true)
      }
    } catch (error) {
      // eslint-disable-next-line no-console
      console.log(error)
      console.log('data response =>', user)
    }
  }

  return (
    <div className="relative flex flex-col items-center rounded-lg bg-white px-24 py-16 md:px-32">
      <h2 className="text-2xl mb-4 font-bold">Registro</h2>

      <form className="flex flex-col space-y-4">

        <button
          type="button"
          className="absolute right-2 top-2 h-8 w-8 cursor-pointer rounded-full border-none bg-transparent"
          onClick={onClose}>
          ✕
        </button>

        <div className="grid grid-cols-2 gap-4">
          <div>
            <input
              {...register('dni')}
              type="text"
              id="dni"
              className="border-gray-300 w-full rounded-lg border px-6 py-4 focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="DNI o NIE"
            />
            {errors.dni && (
              <p className="text-error text-sm">{`${errors.dni?.message}`}</p>
            )}
          </div>

          <div>
            <input
              {...register('email')}
              type="email"
              id="email"
              className="border-gray-300 w-full rounded-lg border px-6 py-4 focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Email"
            />
            {errors.email && (
              <p className="text-error text-sm">{`${errors.email?.message}`}</p>
            )}
          </div>

          <div>
            <input
              {...register('username')}
              type="text"
              id="username"
              className="border-gray-300 w-full rounded-lg border px-6 py-4 focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Username"
            />
            {errors.username && (
              <p className="text-error text-sm">{`${errors.username?.message}`}</p>
            )}
          </div>

          <div>
            {/* <input
            type="text"
            {...register('specialization')}
            id="specialization"
            className="border-gray-300 w-full rounded-lg border px-6 py-4 focus:border-blue-300 focus:outline-none focus:ring"
            placeholder="Especialización"
            /> */}
            <select
              {...register('specialization')}
              id="specialization"
              className="border-gray-300 w-full rounded-lg border px-6 py-4 focus:border-blue-300 focus:outline-none focus:ring">

              <option value="placeholder" style={{color: "#9da3ae"}} selected>Especialización</option>
              <option value="frontend">Frontend</option>
              <option value="backend">Backend</option>
              <option value="fullstack">Fullstack</option>
              <option value="dataScience">Data Science</option>
            </select>

            {errors.specialization && (
              <p className="text-error text-sm">{`${errors.specialization.message}`}</p>
            )}
          </div>

          <div>
              <input
                {...register('password')}
                type="password"
                id="password"
                className="border-gray-300 w-full rounded-lg border px-6 py-4 focus:border-blue-300 focus:outline-none focus:ring"
                placeholder="Contraseña"
              />
              {errors.password && (
                <p className="text-error text-sm">{`${errors.password?.message}`}</p>
              )}
            </div>

          <div>
            <input
              type="password"
              {...register('confirmPassword')}
              id="confirmPassword"
              className="border-gray-300 w-full rounded-lg border px-6 py-4 focus:border-blue-300 focus:outline-none focus:ring"
              placeholder="Repetir contraseña"
            />
            {errors.confirmPassword && (
              <p className="text-error text-sm">{`${errors.confirmPassword?.message}`}</p>
            )}
          </div>

          <div className="mt-8 flex flex-col justify-center">
            <div className="flex items-center gap-1">
              <input
                type="checkbox"
                id="acceptTerms"
                className="h-6 w-6"
                checked={isChecked}
                onChange={(e) => setIsChecked(e.target.checked)}
              />
              <label htmlFor="acceptTerms" className=" mr-2 text-sm">
                Acepto{' '}
                <span className='cursor-pointer' style={{ textDecoration: 'underline' }}>
                  términos legales
                </span>
              </label>
            </div>            
          </div>

          <button
            type="button"
            className="mt-8 h-12 cursor-pointer rounded-lg border-none bg-primary text-white font-bold"
            onClick={handleSubmit(sendRegister)}>
            Registro
          </button>
        </div>
        <div className='text-sm'>
          {checkError && (
            <p className={`${isChecked ? 'hidden' : 'text-error'}`}>
              Debes aceptar los términos legales para completar el registro
            </p>
          )}      

        </div>
      </form>

      <div className="mt-4 text-center">
        <button
          type="button"
          onClick={onOpenLoginPopup}
          className="mt-8 cursor-pointer font-bold text-black-2"
          style={{ textDecoration: 'underline' }}>
          ¿Tienes cuenta? acceder
        </button>
      </div>
    </div>
  )
}

export default RegisterPopup
