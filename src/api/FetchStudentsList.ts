import { TStudent } from '../../types';
import api from './api';

export const FetchStudentsList = async (selectedRoles: string[] = []): Promise<TStudent[]> => {
  let queryParams = '';

  if (selectedRoles.length > 0) {
    queryParams += `specialization=${selectedRoles.join(',')}`;
  }

  const url = `//localhost:8000/api/v1/student/resume/list${queryParams ? `?${queryParams}` : ''}`;

  const response = await api.get(url);

  return response;
};
