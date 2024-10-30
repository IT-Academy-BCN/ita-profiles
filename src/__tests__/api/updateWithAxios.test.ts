import { describe, it, expect } from 'vitest'
import { updateWithAxios } from '../../api/student/updateWithAxios'
import { configureMockAdapter } from '../setup'

const mock = configureMockAdapter()

describe('updateWithAxios', () => {
    it('should return profile data on successful request', async () => {
        const mockResponse = { profile: { name: 'John Doe' } }
        mock.onPut('/api/profile').reply(200, mockResponse)

        const result = await updateWithAxios({
            url: '/api/profile',
            formData: { name: 'John Doe' },
        })

        expect(result).toEqual(mockResponse.profile)
    })

    // it('should throw an error on failed request', async () => {
    //     mock.onPut('/api/profile').reply(400, {
    //         message: 'Error de actualización',
    //     })

    //     await expect(
    //         updateWithAxios({
    //             url: '/api/profile',
    //             formData: { name: 'John Doe' },
    //         }),
    //     ).rejects.toThrow('Error de actualización')
    // })

    // it('should throw an unknown error if not an Axios error', async () => {
    //     mock.onPut('/api/profile').networkError()

    //     await expect(
    //         updateWithAxios({
    //             url: '/api/profile',
    //             formData: { name: 'John Doe' },
    //         }),
    //     ).rejects.toThrow('Error desconocido')
    // })

})
