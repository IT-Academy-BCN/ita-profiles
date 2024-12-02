import { createAsyncThunk } from '@reduxjs/toolkit';
import axios from 'axios';
import { resumes } from '../../api/student/getStudentDetailWithId';
import { TLanguage } from '../../../types';

type DataFetch = {
  name: string,
  level: string
}
export const updateProfileLanguagesThunk = createAsyncThunk(
  "updateProfileLanguagesThunk",
  async (payload: TLanguage[]) => {

    const data: DataFetch = {
      "name": payload[0].name,
      "level": payload[0].level
    }
    const axiosPost = await axios.post(`//localhost:8000/api/v1/student/${localStorage.getItem("studentID")}/resume/${resumes.languages}`, data, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('token')}`,
        'Accept': 'application/json'
      }
    })

    return axiosPost.data.message
  }
)
