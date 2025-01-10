import { TModality } from '../../../../../types'
import studentModality from '../../../../store/slices/student/modalitySlice'
import { modalityThunk } from '../../../../store/thunks/getDetailResourceStudentWithIdThunk'

const modality: TModality[] = []

describe('studentModality', () => {
    it('should be defined', () => {
        expect(studentModality).toBeDefined()
    })

    it('should be defined modalityThunk', () => {
        expect(modalityThunk).toBeDefined()
    })

    it('should be defined const modality type TModality', () => {
        expect(modality).toBeDefined()
    })

    it('should be return initialValues', () => {
        expect(
            studentModality(undefined, {
                type: 'object',
                payload: [],
            }),
        ).toEqual({
            isLoadingModality: false,
            isErrorModality: false,
            modality: [],
        })
    })

    it('It is expected to return value ​​when the request is pending resolution.', () => {
        expect(
            studentModality(undefined, {
                type: 'modalityThunk/pending',
                payload: [],
            }),
        ).toEqual({
            isLoadingModality: true,
            isErrorModality: false,
            modality: [],
        })
    })

    it('It is expected to return values when the request is fulfilled resolution', () => {
        expect(
            studentModality(undefined, {
                type: 'modalityThunk/fulfilled',
                payload: {
                    modality: ['Presencial', 'Remot'],
                },
            }),
        ).toEqual({
            isLoadingModality: false,
            isErrorModality: false,
            modality: ['Presencial', 'Remot'],
        })
    })

    it('It is expected to return values when the request is rejected resolution', () => {
        expect(
            studentModality(undefined, {
                type: 'modalityThunk/rejected',
                payload: [],
            }),
        ).toEqual({
            isLoadingModality: false,
            isErrorModality: true,
            modality: [],
        })
    })
})
