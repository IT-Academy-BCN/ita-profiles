import axios from 'axios'

export const fetchModalityData = async (studentId: string | null) => {

  try {
    const response = await axios.get(
      `//localhost:8000/api/v1/student/${studentId}/resume/detail`,
    )
    return response.data.modality
  } catch (error) {
    // eslint-disable-next-line no-console
    console.error('Error fetching modality data:', error)
    throw error
  }
}
