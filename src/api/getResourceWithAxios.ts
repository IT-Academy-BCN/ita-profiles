import axios from 'axios'

const getResourceWithAxios = async (url: string) => {
    try {
        const response = await axios.get(
            `http://localhost:8000/api/v1${url}`,
        )
        return response.data;
    } catch (err) {
        return console.log('error', err)
    }
}

export {
    getResourceWithAxios
}

