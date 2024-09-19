import axios from 'axios'

export const fetchStudentDetail = async (studentId: string | null) => {

  try {
    const response = await axios.get(`//localhost:8000/api/v1/student/${studentId}/resume/detail`)
    return response.data.data;
  } catch (error) {
    // eslint-disable-next-line no-console
    console.error('Error fetching student detail data:', error)
    throw error
  }

}
