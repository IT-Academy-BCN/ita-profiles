import axios from 'axios'

const baseApi = ''
export const getAdditionalTraining = async (studentUUID: string | null) => {
  try {
    const response = await axios.get(
      `${baseApi}//localhost:8000/api/v1/students/${studentUUID}/additionaltraining`,
    )
    return response.data.additional_trainings
  } catch (err) {
    // eslint-disable-next-line no-console
    return console.log('error', err)
  }
}
