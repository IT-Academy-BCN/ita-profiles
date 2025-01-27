import { createAsyncThunk } from '@reduxjs/toolkit';
import axios from 'axios';

export type SignUpState =
  {
    username: string,
    dni: string,
    email: string,
    specialization: string,
    password: string,
    password_confirmation: string,
    terms: string
  }

export const registerNewUserThunk = createAsyncThunk(
  "registerNewUserThunk",
  async (data: SignUpState) => {
    const axiosPost = await axios.post(`http://127.0.0.1:8000/api/v1/register`, data)

    return axiosPost.data
  }
)
