import { createAsyncThunk } from '@reduxjs/toolkit';
import api, { resumes } from '../../api/api';

export const updateProfilePhotoThunk = createAsyncThunk(
  "updateProfilePhotoThunk",
  async (payload: { studentId: string, data: FormData }) => {
    const axiosPost = await api.post(`/student/${payload.studentId}/resume/${resumes.photo}`, payload.data)
    return axiosPost.data
  }
)
