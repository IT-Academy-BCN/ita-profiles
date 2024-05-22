import axios from 'axios'


export const fetchModalityData = async (studentUUID: string | null) => {

        try {
          const response = await axios.get(
            `https://itaperfils.eurecatacademy.org/api/v1/modality/${studentUUID}`,
          
          )
          return response.data
        } catch (error) {
          // eslint-disable-next-line no-console
          console.error('Error fetching modality data:', error)
          throw error
        }
        
     }

