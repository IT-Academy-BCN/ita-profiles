import axios, { AxiosError } from 'axios';

const token = globalThis.localStorage.getItem('token') || ''
const API_URL = '//localhost:8000/api/v1'

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

axios.defaults.baseURL = API_URL
axios.defaults.headers.Authorization = `Bearer ${token}`;
axios.defaults.headers.Accept = 'application/json';

export default {
  get: async (url: string) => {
    try {
      const response = await axios.get(`${url}`)
      return response.data;
    } catch (e) {
      const error = e as AxiosError
      throw new Error(error.message);
    }
  },
  post: async (url: string, data: FormData) => {
    try {
      const request = await axios.post(url, data)
      const response = request.data;
      return response;
    } catch (e) {
      const error = e as AxiosError
      throw new Error(error.message);
    }

  },
  update: async (url: string, data: FormData) => {
    try {
      const request = await axios.put(url, data)
      const response = request.data;
      return response;
    } catch (e) {
      const error = e as AxiosError
      throw new Error(error.message);
    }
  },
  delete: async (url: string) => {
    try {
      const request = await axios.delete(url)
      const response = await request.data;
      return response;
    } catch (e) {
      const error = e as AxiosError
      throw new Error(error.message);
    }
  }
}

export {
  axios
}