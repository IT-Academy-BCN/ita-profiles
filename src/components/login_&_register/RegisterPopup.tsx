import { zodResolver } from '@hookform/resolvers/zod'
import React, { useState } from 'react'
import { SubmitHandler, useForm } from 'react-hook-form'
import { z } from 'zod'
import { UserSchema } from '../../schemes/schemas'
import Modal from '../molecules/Modal'
import { REGEX_DNI, REGEX_EMAIL, REGEX_PASWWORD, REGEX_USERNAME } from '../../utils/regex'
import { useAppDispatch, useAppSelector } from '../../hooks/ReduxHooks'
import { registerNewUserThunk } from '../../store/thunks/registerNewUserThunk'

type RegisterPopupProps = {
  onClose: () => void
  onOpenLoginPopup: () => void,
  isOpen: boolean
}
enum Specialization {
  Frontend = "Frontend",
  Backend = "Backend",
  Fullstack = "Fullstack",
  DataScience = "Data Science",
  NotSet = "Not Set"
}
const specializationValues = Object.values(Specialization)
console.log(specializationValues)
type TFormSchema = z.infer<typeof UserSchema>

const RegisterPopup: React.FC<RegisterPopupProps> = ({
  onClose,
  onOpenLoginPopup,
  isOpen
}) => {

  const { isErrorCreateUser, isSuccessCreateUser, isLoadingCreateUser } = useAppSelector(state => state.ShowUserReducer.createUser)
  const dispatch = useAppDispatch();

  const [isChecked, setIsChecked] = useState(false)
  const [checkError, setCheckError] = useState(false)

  const {
    register,
    handleSubmit,
    reset,
    formState: { errors },
  } = useForm<TFormSchema>({ resolver: zodResolver(UserSchema) })

  const sendRegister: SubmitHandler<TFormSchema> = async (data) => {
    if (isChecked) {
      const form = {
        ...data,
        terms: data.terms.toString()
      }
      dispatch(registerNewUserThunk(form))
      reset()
      onClose()
    } else {
      setCheckError(true)
    }

  }

  return (
    <Modal isOpen={isOpen} onClose={onClose}>
      <div className="w-120 flex flex-col items-center rounded-lgp-5 md:p-20">
        <h2 className="text-lg font-bold md:text-2xl">Registro</h2>
        <form className="flex flex-col space-y-4" autoComplete='on'>
          <div className="grid grid-cols-2 gap-4">
            {isErrorCreateUser && <h1>{isErrorCreateUser.toString()}</h1>}
            {isLoadingCreateUser && 'Loading'}
            {isSuccessCreateUser && 'Ok'}
            <div>
              <input
                {...register('dni')}
                type="text"
                id="dni"
                className="border-gray-300 w-full rounded-lg border p-2 px-4 py-4 focus:border-blue-300 focus:outline-none focus:ring md:p-4 md:px-6 md:py-2"
                placeholder="DNI o NIE"
                pattern={REGEX_DNI.toString()}
                title="DNI o NIE"
              />
              {errors.dni && (
                <p className="text-error">{`${errors.dni?.message}`}</p>
              )}
            </div>

            <div>
              <input
                {...register('email')}
                type="email"
                id="email"
                className="border-gray-300 w-full rounded-lg border p-2 px-4 py-4 focus:border-blue-300 focus:outline-none focus:ring md:p-4 md:px-6 md:py-2"
                placeholder="Email"
                pattern={REGEX_EMAIL.toString()}
                required
                title='Email'
              />
              {errors.email && (
                <p className="text-error">{`${errors.email?.message}`}</p>
              )}
            </div>
          </div>
          <div className="grid grid-cols-2 gap-4">
            <div>
              <input
                {...register('username')}
                type="text"
                id="username"
                className="border-gray-300 w-full rounded-lg border p-2 px-4 py-4 focus:border-blue-300 focus:outline-none focus:ring md:p-4 md:px-6 md:py-2"
                placeholder="Username"
                pattern={REGEX_USERNAME.toString()}
                required
                title='Username'
              />
              {errors.username && (
                <p className="text-error">{`${errors.username?.message}`}</p>
              )}
            </div>
            <div>
              <select required title={`Especializaciónes, ${specializationValues.map(specialization => specialization).join(", ")}`} {...register('specialization')} name="specialization" id="specialization" className="border-gray-300 w-full rounded-lg border p-2 px-4 py-4 focus:border-blue-300 focus:outline-none focus:ring md:p-4 md:px-6 md:py-2">
                {specializationValues.map((specialization) => <option key={specialization} value={specialization} title={specialization}>{specialization}</option>)}
              </select>
              {errors.specialization && (
                <p className="text-error">{`${errors.specialization.message}`}</p>
              )}
            </div>
          </div>
          <div className="grid grid-cols-2 gap-4">
            <div>
              <input
                type="password"
                {...register('password_confirmation')}
                id="confirmPassword"
                className="border-gray-300 w-full rounded-lg border p-2 px-4 py-4 focus:border-blue-300 focus:outline-none focus:ring md:p-4 md:px-6 md:py-2"
                placeholder="Confirm Password"
                pattern={REGEX_PASWWORD.toString()}
                required
                title='Confirm Password'
              />
              {errors.password_confirmation && (
                <p className="text-error">{`${errors.password_confirmation?.message}`}</p>
              )}
            </div>
            <div>
              <input
                {...register('password')}
                type="password"
                id="password"
                className="border-gray-300 w-full rounded-lg border p-2 px-4 py-4 focus:border-blue-300 focus:outline-none focus:ring md:p-4 md:px-6 md:py-2"
                placeholder="Password"
                pattern={REGEX_PASWWORD.toString()}
                required
                title='Password'
              />
              {errors.password && (
                <p className="text-error">{`${errors.password?.message}`}</p>
              )}
            </div>

          </div>
          <div className="flex items-center justify-center space-x-8 p-4 md:p-5 ">
            <div className="flex flex-col">
              <div className="flex items-center gap-1">
                <input
                  {...register('terms')}
                  type="checkbox"
                  id="terms"
                  className="h-6 w-6"
                  checked={isChecked}
                  onChange={(e) => setIsChecked(e.target.checked)}
                  required
                />
                <label htmlFor="terms" className=" mr-2 text-sm">
                  Acepto{' '}
                  <span style={{ textDecoration: 'underline' }}>
                    términos legales
                  </span>
                </label>
              </div>
              {checkError && (
                <p className={`${isChecked ? 'hidden' : 'text-error'}`}>
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
    </Modal>
  )
}

export default RegisterPopup
