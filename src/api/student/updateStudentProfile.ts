import axios from 'axios'
import { TStudentFormData } from '../../interfaces/interfaces'

export const updateStudentProfile = async ({
    id,
    formData,
}: {
    id: string
    formData: TStudentFormData
}) => {
    const studentId = id
    const url = `http://localhost:8000/api/v1/student/${studentId}/resume/profile`
    try {
        const response = await axios.put(url, formData)
        console.log('Perfil actualizado con éxito:', response.data)
    } catch (error: unknown) {
        if (axios.isAxiosError(error)) {
            console.error(
                'Error al actualizar el perfil:',
                error.response?.data,
            )
            throw new Error(
                error.response?.data || 'error al actualizar el perfil',
            )
        } else {
            console.error('Error desconocido:', error)
            throw new Error('Error desconocido')
        }
    }
}
