import { createAsyncThunk } from '@reduxjs/toolkit';
import { callUpdateStudent } from '../../api/student/callUpdateStudent';
import { resumes } from '../../api/student/getStudentDetailWithId';

export const updateProfilePhotoThunk = createAsyncThunk(
  "updateProfilePhotoThunk",
  async (payload: { studentId: string, data: object }) => {
    const query = {
      url: `//localhost:8000/api/v1/student/${payload.studentId}/resume/${resumes.photo}`,
      formData: payload.data,
      options: {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`,
          'Accept': 'application/json'
        },
        body: payload.data
      }
    }
    const data = await callUpdateStudent(query)
    return data
  }
)
