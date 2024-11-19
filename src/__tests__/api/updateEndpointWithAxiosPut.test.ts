// import { describe, it, expect } from 'vitest'
// import { configureMockAdapter } from '../setup'
// import { callUpdateStudent } from '../../api/student/callUpdateStudent'

// const mock = configureMockAdapter()

// describe('callUpdateStudent test', () => {
//     const studentID = 'mocked-student-id'
//     const apiUrl = `http://localhost:8000/api/v1/student/${studentID}/resume/profile`
//     const formData = {
//         name: 'AZoQr YZMcGPf Arreglar campo Arreglar campo',
//         surname: 'arreglar campo',
//         subtitle: 'Backend developer Java',
//         github_url: 'https://github.com/glittle',
//         linkedin_url: 'https://linkedin.com/lura.tromp',
//         about: 'Qui est itaque quis iusto voluptas dolores. Necessitatibus ut dolores id commodi sunt velit nemo. Aspernatur et deserunt provident ratione soluta a. Ut voluptate accusamus in eum. Reprehenderit animi aut quae ipsum fugit veniam ipsa iure.',
//         tags_ids: [25, 3],
//     }

//     it('should return successfull message when endpoint is updated', async () => {
//         const mockResponse = {
//             profile: "El perfil de l'estudiant s'actualitzat correctament",
//         }
//         mock.onPut(apiUrl, formData).reply(200, mockResponse)
//         const result = await callUpdateStudent({
//             url: apiUrl,
//             formData,
//         })
//         expect(result).toEqual(mockResponse)
//     })

//     it('should throw an especific error when endpoint update request fails ', async () => {
//         const mockResponse = 'Error de actualización'
//         mock.onPut(apiUrl, formData).reply(400, mockResponse)
//         await expect(
//             callUpdateStudent({
//                 url: apiUrl,
//                 formData,
//             }),
//         ).rejects.toThrow('Error de actualización')
//     })

//     it('should throw an unknown error  when endpoint update request fails and it not an Axios error', async () => {
//         mock.onPut(apiUrl, formData).networkError()
//         await expect(
//             callUpdateStudent({
//                 url: apiUrl,
//                 formData,
//             }),
//         ).rejects.toThrow('Error al ejecutar la petición')
//     })
// })

describe("Algo pasa por aquí Tomi", () => {
    // No sé qué hace, el código que está comentado arriba, está dando errores.
    it("Revisar", () => {
        expect(false).toBeTruthy();
    })
})
