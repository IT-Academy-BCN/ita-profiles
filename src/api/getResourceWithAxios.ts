import axios from 'axios'

const getResourceWithAxios = async (url: string) => {
    try {
        const response = await axios.get(
            `//localhost:8000/api/v1${url}`,
        )
        // console.log(response.data);
        return response.data;
    } catch (err) {
        // eslint-disable-next-line no-console
        return console.log('error', err)
    }
}


// More functions ...

export {
    getResourceWithAxios
}