// eslint-disable-next-line no-unused-vars,@typescript-eslint/no-unused-vars
import axios, { AxiosError } from 'axios';
import { TStudentList } from '../../types';

// eslint-disable-next-line consistent-return
export const FetchStudentsList = async (selectedRoles: Array<string> = []) => {

  try {
    let queryParams = '';

    // Construir la cadena de consulta para roles seleccionados
    if (selectedRoles.length > 0) {
      queryParams += `specialization=${selectedRoles.join(',')}`;
    }

    // Construir la URL completa con la cadena de consulta
    const url = `//localhost:8000/api/v1/student/resume/list${queryParams ? `?${queryParams}` : ''}`;

    const response = await axios.get<TStudentList[]>(url);
    return response.data;
    // @ts-expect-error throws AxiosError exception
  } catch (e: AxiosError) {
    // eslint-disable-next-line no-console
    throw new DOMException(e.message, 'ConnectionFailed');
  }
};
