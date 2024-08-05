import axios from "axios"

export const FetchStudentLanguages = async (studentId: string | null) => {
  try {
    const response = await axios.get(`//localhost:8000/api/v1/student/${studentId}/resume/languages`);
    return response.data.languages;
  } catch (error) {
    throw new Error('Error fetching languages');
  }
};