import axios from 'axios'

export const callUpdateStudent = async ({
    url,
    formData,
    options = null
}: {
    url: string
    formData: object,
    options?: object | null
}) => {
    try {
        let response;
        if (options) {
            response = await axios.put(url, formData, options)
        } else {
            response = await axios.put(url, formData)
        }
        return response.data
    } catch (error: unknown) {
        if (axios.isAxiosError(error)) {
            console.error('Error en la operación:', error.response?.data)
            throw new Error(
                error.response?.data || 'Error al ejecutar la petición',
            )
        } else {
            console.error('Error desconocido:', error)
            throw new Error('Error desconocido')
        }
    }
}
