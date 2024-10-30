import { describe, it, expect } from 'vitest'
import { updateWithAxios } from '../../api/student/updateWithAxios'
import { configureMockAdapter } from '../setup'

const mock = configureMockAdapter()

describe('updateWithAxios', () => {
    const studentID = 'mocked-student-id'
    const apiUrl = `http://localhost:8000/api/v1/student/${studentID}/resume/profile`
    const formData = {
        name: 'AZoQr YZMcGPf Arreglar campo Arreglar campo',
        surname: 'arreglar campo',
        subtitle: 'Backend developer Java',
        github_url: 'https://github.com/glittle',
        linkedin_url: 'https://linkedin.com/lura.tromp',
        about: 'Qui est itaque quis iusto voluptas dolores. Necessitatibus ut dolores id commodi sunt velit nemo. Aspernatur et deserunt provident ratione soluta a. Ut voluptate accusamus in eum. Reprehenderit animi aut quae ipsum fugit veniam ipsa iure.',
        tags_ids: [25, 3],
    }

    it('should return successful message', async () => {
        const mockResponse = {
            profile: "El perfil de l'estudiant s'actualitza correctament",
        }
        mock.onPut(apiUrl, formData).reply(200, mockResponse)
        const result = await updateWithAxios({
            url: apiUrl,
            formData,
        })
        expect(result).toEqual(mockResponse)
    })

    it('should throw an error on failed request', async () => {
        const mockResponse = {
            message: 'Error de actualización',
        }
        mock.onPut(apiUrl, formData).reply(400, mockResponse)
        await expect(
            updateWithAxios({
                url: apiUrl,
                formData: { name: 'John Doe' },
            }),
        ).rejects.toThrow(Error)
    })

    it('should throw an unknown error if not an Axios error', async () => {
        mock.onPut(apiUrl, formData).networkError()
        await expect(
            updateWithAxios({
                url: apiUrl,
                formData,
            }),
        ).rejects.toThrow('Error al ejecutar la petición')
    })
})
