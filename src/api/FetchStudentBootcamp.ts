import axios from 'axios'


export const fetchBootcampData = async (studentUUID: string | null) => {

        try {
          const response = await axios.get(
            `https://itaperfils.eurecatacademy.org/api/v1/students/${studentUUID}/bootcamp`,

          )
          return response.data
        
        } catch (error) {
          // eslint-disable-next-line no-console
          console.error('Error fetching bootcamp data:', error)
          throw error
        }
        
     }
    
