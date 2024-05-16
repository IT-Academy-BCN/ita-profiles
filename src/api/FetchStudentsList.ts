// eslint-disable-next-line no-unused-vars,@typescript-eslint/no-unused-vars
import axios, { AxiosError } from 'axios';
import { IStudentList } from '../interfaces/interfaces';

// eslint-disable-next-line consistent-return
export const FetchStudentsListHome = async (selectedRoles:Array<string>= []) => {

  try {
    let queryParams = '';

    // Construir la cadena de consulta para roles seleccionados
    if (selectedRoles.length > 0) {
      queryParams += `specialization=${selectedRoles.join(',')}`;
    }

    // Construir la URL completa con la cadena de consulta
    const url = `https://itaperfils.eurecatacademy.org/api/v1/student/list/for-home${queryParams ? `?${queryParams}` : ''}`;

    const response = await axios.get<IStudentList[]>(url);
    return response.data;
    // @ts-expect-error throws AxiosError exception
  } catch (e: AxiosError) {
    // eslint-disable-next-line no-console
    throw new DOMException(e.message, 'ConnectionFailed');
  }
  };