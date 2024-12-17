import axios, { AxiosError } from 'axios';


export const FetchStudentsList = async (selectedRoles: Array<string> = []) => {
  try {
    let queryParams = '';

    if (selectedRoles.length > 0) {
      queryParams += `specialization=${selectedRoles.join(',')}`;
    }

    const url = `//localhost:8000/api/v1/student/resume/list${queryParams ? `?${queryParams}` : ''}`;

    const response = await axios.get(url);

    return response;

  } catch (e) {
    const error = e as AxiosError
    throw new DOMException(error.message, 'ConnectionFailed');
  }
};
