import { z } from 'zod';

const dni = /^(\d{8})([A-Z])$/;
const nie = /^[XYZ]\d{7,8}[A-Z]$/;
const regexDNI = z
  .string()
  .regex(dni)
  .max(9, { message: 'El documento deber contener 9 caracteres' });
const regexNIE = z
  .string()
  .regex(nie)
  .max(9, { message: 'El documento deber contener 9 caracteres' });

export const UserSchema = z
  .object({
    username: z.string().min(1, {
      message: 'El nombre de usuario es requerido',
    }),
    dni: z.union([regexDNI, regexNIE]),
    email: z.string().email({ message: 'Este email no es válido' }),
    specialization: z
      .string()
      .min(1, { message: 'La especialización es requerida' }),
    password: z.string().min(8, {
      message: 'La contraseña debe tener al menos 8 caracteres',
    }),
    confirmPassword: z
      .string()
      .min(1, { message: 'Confirmar contraseña es requerido' }),
  })
  .refine((data) => data.password === data.confirmPassword, {
    message: 'La contraseña no coincide',
    path: ['confirmPassword'],
  });
