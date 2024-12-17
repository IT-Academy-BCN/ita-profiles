import { createAsyncThunk } from '@reduxjs/toolkit';
import { TLanguage } from '../../../types';
import api, { resumes } from '../../api/api';

export const updateProfileLanguagesThunk = createAsyncThunk(
  "updateProfileLanguagesThunk",
  async (payload: TLanguage[]) => {
    const formData = new FormData()
    formData.append('name', payload[0].name)
    formData.append('level', payload[0].level)
    const axiosPost = await api.post(`//localhost:8000/api/v1/student/${localStorage.getItem("studentID")}/resume/${resumes.languages}`, formData)
    return axiosPost.message
  }
)
