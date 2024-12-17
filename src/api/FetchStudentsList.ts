import { TStudent } from "../../types";
import api from "./api";

export const FetchStudentsList = async (selectedRoles: Array<string> = []): Promise<TStudent[]> => {

  let queryParams = '';

  if (selectedRoles.length > 0) {
    queryParams += `specialization=${selectedRoles.join(',')}`;
  }

  const url = `/student/resume/list${queryParams ? `?${queryParams}` : ''}`;

  const response = await api.get(url);
  return response;
};
