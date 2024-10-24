import axios from 'axios'

export const updateStudentProfile = async ({
    url,
    formData,
}: {
    url: string
    formData: object
}) => {
    try {
        const response = await axios.put(url, formData)
        console.log('Operación exitosa', response.data)
        return response
    } catch (error: unknown) {
        if (axios.isAxiosError(error)) {
            console.error('Error en la operación:', error.response?.data)
            throw new Error(error.response?.data || 'error ejecutar petición')
        } else {
            console.error('Error desconocido:', error)
            throw new Error('Error desconocido')
        }
    }
}
