import { createAsyncThunk } from '@reduxjs/toolkit';
import axios from 'axios';

export const updateProfilePhotoThunk = createAsyncThunk(
  "updateProfilePhotoThunk",
  async (payload: { studentId: string, data: FormData }) => {
    try {
      const query = await axios.put(`//localhost:8000/api/v1/student/${payload.studentId}/resume/photo`, payload.data, {
        headers: {
          "Authorization": `Bearer ${localStorage.getItem("token")}`,
          "Content-Type": "application/json"
        }
      })

      return query.data
    } catch (error) {
      const err = error as Error;
      throw new Error(err.message)
    }

  }
)