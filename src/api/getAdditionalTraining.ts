import axios from 'axios'

export const getAdditionalTraining = async (studentId: string | null) => {
  try {
    const response = await axios.get(
      `//localhost:8000/api/v1/student/${studentId}/resume/additionaltraining`,
    )
    return response.data.additional_trainings
  } catch (err) {
    // eslint-disable-next-line no-console
    return console.log('error', err)
  }
}
