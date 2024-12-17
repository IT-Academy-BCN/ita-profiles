import { createAsyncThunk } from '@reduxjs/toolkit';
import api, { resumes } from '../../api/api';

export const updateProfilePhotoThunk = createAsyncThunk(
  "updateProfilePhotoThunk",
  async (payload: { studentId: string, data: FormData }) => {
    const axiosPost = await api.post(`//localhost:8000/api/v1/student/${payload.studentId}/resume/${resumes.photo}`, payload.data)
    return axiosPost
  }
)
