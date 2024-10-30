import axios from 'axios'

export const updateWithAxios = async ({
    url,
    formData,
}: {
    url: string
    formData: object
}) => {
    try {
        const response = await axios.put(url, formData)
        console.log(response.data)
        return response.data
    } catch (error: unknown) {
        if (axios.isAxiosError(error)) {
            console.error('Error en la operación:', error.response?.data)
            throw new Error(error.response?.data || 'Error al ejecutar la petición')
        } else {
            console.error('Error desconocido:', error)
            throw new Error('Error desconocido')
        }
    }
}
