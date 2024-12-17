import api from './api';

export const FetchStudentsList = async (selectedRoles: Array<string> = []) => {
  try {
    let queryParams = '';

    if (selectedRoles.length > 0) {
      queryParams += `specialization=${selectedRoles.join(',')}`;
    }

    const url = `/student/resume/list${queryParams ? `?${queryParams}` : ''}`;

    const response = await api.get(url);
    return response;

  } catch (e) {
    const error = e as Error
    throw new DOMException(error.message, 'ConnectionFailed');
  }
};
