import axios from 'axios';
import { LoginResponse } from '../interfaces/interfaces';



export const fetchLogin = async (data: { dni: string; password: string }): Promise<LoginResponse> => {
  try {
    const response = await axios.post<LoginResponse>('https://itaperfils.eurecatacademy.org/api/v1/signin', data);
    return response.data;
  } catch (error) {
    console.error('Error fetching login data:', error);
    throw error;
  }
};
