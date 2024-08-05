import axios from 'axios'

export const fetchModalityData = async (studentId: string | null) => {

  try {
    const response = await axios.get(
      `//localhost:8000/api/v1/student/${studentId}/resume/modality/`,
    )
    return response.data
  } catch (error) {
    // eslint-disable-next-line no-console
    console.error('Error fetching modality data:', error)
    throw error
  }
}
