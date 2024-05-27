import axios from 'axios'


export const fetchAboutData = async (studentUUID: string | null) => {

        try {
          const response = await axios.get(
            `https://itaperfils.eurecatacademy.org/api/v1/student/${studentUUID}/detail/for-home`,
          
          )
          return response.data.data;
        } catch (error) {
          // eslint-disable-next-line no-console
          console.error('Error fetching about data:', error)
          throw error
        }
        
     }
