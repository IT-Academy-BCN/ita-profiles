import axios from 'axios'


export const fetchBootcampData = async (studentId: string | null) => {

  try {
    const response = await axios.get(
      `//localhost:8000/api/v1/student/${studentId}/resume/bootcamp`,
    )
    return response.data

  } catch (error) {
    // eslint-disable-next-line no-console
    console.error('Error fetching bootcamp data:', error)
    throw error
  }
}

