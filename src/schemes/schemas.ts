import { z } from 'zod';
import { REGEX_USERNAME, REGEX_PASWWORD, REGEX_DNI_NIF_NIE, REGEX_DNI, REGEX_NIE } from '../utils/regex';

const regexDNI = z
  .string()
  .regex(REGEX_DNI)
  .max(9, { message: 'El documento deber contener 9 carácteres' });
const regexNIE = z
  .string()
  .regex(REGEX_NIE)
  .max(9, { message: 'El documento deber contener 9 carácteres' });
const passwordSchema = z.string().regex(REGEX_PASWWORD, {
  message: 'La contraseña debe contener al menos una letra mayúscula, un carácter especial y tener al menos 8 caracteres.'
});

export const UserSchema = z
  .object({
    username: z.string()
      .regex(REGEX_USERNAME, {
        message: 'El nombre de usuario no es válido',
      })
      .min(3, {
        message: 'El nombre de usuario necesita minimo 3 caracteres',
      }),
    dni: z.string().regex(REGEX_DNI_NIF_NIE).max(9, { message: 'El documento deber contener 9 carácteres' }),
    email: z.string().email({ message: 'Este email no es válido.' }),
    specialization: z
      .string()
      .min(1, { message: 'La especialización es requerida' }),

    password: passwordSchema,
    password_confirmation: z
      .string()
      .regex(REGEX_PASWWORD, {
        message: 'Confirmar password es requerido y debe contener al menos una letra mayúscula, un carácter especial y tener al menos 8 caracteres.',
      })
      .min(1, { message: 'Confirmar password es requerido' }),
    terms: z.boolean(),
  })
  .refine((data) => data.password === data.password_confirmation, {
    message: 'La contraseña no coincide',
    path: ['confirmPassword'],
  });

export const LoginUserSchema = z
  .object({
    dni: z.union([regexDNI, regexNIE]),
    password: z.string().min(8, {
      message: 'La contraseña debe tener al menos 8 caracteres',
    }),
  });
