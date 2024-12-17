import axios, { AxiosError } from 'axios';
import { TStudentFormData } from '../../types';



export const token = globalThis.localStorage.getItem('token');
export const API_URL = '//localhost:8000/api/v1'

type TResumes = {
  photo: string,
  languages: string,
  modality: string,
  list: string,
  additionaltraining: string,
  bootcamp: string,
  collaborations: string,
  detail: string,
  projects: string,
  profile: string
}

export const resumes: TResumes = {
  photo: "photo",
  languages: "languages",
  modality: "modality",
  list: "list",
  additionaltraining: "additionaltraining",
  bootcamp: "bootcamp",
  collaborations: "collaborations",
  detail: "detail",
  projects: "projects",
  profile: "profile",
}


axios.defaults.headers.common.Authorization = `Bearer ${token}`;
axios.defaults.headers.common.Accept = 'application/json';

export default {
  get: async (url: string) => {
    try {
      const response = await axios.get(url)
      return response.data;
    } catch (e) {
      const error = e as AxiosError
      throw new DOMException(error.message, 'ConnectionFailed');
    }
  },
  post: async (url: string, data: FormData | TStudentFormData) => {
    try {
      const request = await axios.post(url, data)
      const response = request.data;
      console.log(response)
      return response;
    } catch (e) {
      const error = e as AxiosError
      throw new DOMException(error.message, 'ConnectionFailed');
    }

  },
  update: async (url: string, data: FormData | TStudentFormData) => {
    try {
      const request = await axios.put(url, data)
      const response = request.data;
      console.log(response)
      return response;
    } catch (e) {
      const error = e as AxiosError
      throw new DOMException(error.message, 'ConnectionFailed');
    }
  },
  delete: async (url: string) => {
    try {
      const request = await axios.delete(url)
      const response = request.data;
      return response;
    } catch (e) {
      const error = e as AxiosError
      throw new DOMException(error.message, 'ConnectionFailed');
    }
  }
}

export {
  axios
}