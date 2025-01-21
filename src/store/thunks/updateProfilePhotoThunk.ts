import { createAsyncThunk } from '@reduxjs/toolkit';
import axios from 'axios';
import { resumes } from '../../api/student/getStudentDetailWithId';

export const updateProfilePhotoThunk = createAsyncThunk(
  "updateProfilePhotoThunk",
  async (payload: { studentId: string, data: object }) => {
    const axiosPost = await axios.post(`http://localhost:8000/api/v1/student/${payload.studentId}/resume/${resumes.photo}`, payload.data, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('token')}`,
        'Accept': 'application/json'
      }
    })

    return axiosPost.data
  }
)
