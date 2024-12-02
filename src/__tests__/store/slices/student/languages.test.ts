import { TLanguage } from '../../../../../types'
import studentLanguages from '../../../../store/slices/student/languagesSlice'

const languagesData: TLanguage[] = []

const initialState = {
    isLoadingLanguages: false,
    isErrorLanguages: false,
    languagesData,
    isOpenEditAdditionalInformation: false,
    isLoadingUpdateLanguages: false,
    isErrorUpdateLanguages: false,
    notification: {
        message: null,
    }
}

describe('StudentLanguagesTest reducer', () => {
    it('should be defined', () => {
        expect(studentLanguages).toBeDefined()
    })

    it('should be initialState defined', () => {
        expect(initialState).toBeDefined()
    })

    it('should be return initialState', () => {
        expect(
            studentLanguages(undefined, {
                type: 'object',
                payload: [],
            }),
        ).toEqual({
            isLoadingLanguages: false,
            isErrorLanguages: false,
            languagesData: [],
            isOpenEditAdditionalInformation: false,
            isLoadingUpdateLanguages: false,
            isErrorUpdateLanguages: false,
            notification: {
                message: null,
            }
        })
    })

    it('It is expected to return value ​​when the request is pending resolution.', () => {
        expect(
            studentLanguages(undefined, {
                type: 'languagesThunk/pending',
                payload: [],
            }),
        ).toEqual({
            isLoadingLanguages: true,
            isErrorLanguages: false,
            languagesData: [],
            isOpenEditAdditionalInformation: false,
            isLoadingUpdateLanguages: false,
            isErrorUpdateLanguages: false,
            notification: {
                message: null,
            }
        })
    })

    it('It is expected to return values when the request is fulfilled resolution', () => {
        expect(
            studentLanguages(undefined, {
                type: 'languagesThunk/fulfilled',
                payload: {
                    languages: {
                        language_id: 'string',
                        language_name: 'string',
                        language_level: 'string',
                    },
                },
            }),
        ).toEqual({
            isLoadingLanguages: false,
            isErrorLanguages: false,
            languagesData: {
                language_id: 'string',
                language_name: 'string',
                language_level: 'string',
            },
            isOpenEditAdditionalInformation: false,
            isLoadingUpdateLanguages: false,
            isErrorUpdateLanguages: false,
            notification: {
                message: null,
            }
        })
    })

    it('It is expected to return values when the request is rejected resolution', () => {
        expect(
            studentLanguages(undefined, {
                type: 'languagesThunk/rejected',
                payload: [],
            }),
        ).toEqual({
            isLoadingLanguages: false,
            isErrorLanguages: true,
            languagesData: [],
            isOpenEditAdditionalInformation: false,
            isLoadingUpdateLanguages: false,
            isErrorUpdateLanguages: false,
            notification: {
                message: null,
            }
        })
    })
})
describe("updateProfileLanguagesThunk", () => {
    it('It is expected to return value ​​when the request is pending resolution.', () => {
        expect(
            studentLanguages(undefined, {
                type: 'updateProfileLanguagesThunk/pending',
                payload: [],
            }),
        ).toEqual({
            isLoadingLanguages: false,
            isErrorLanguages: false,
            languagesData: [],
            isOpenEditAdditionalInformation: false,
            isLoadingUpdateLanguages: true,
            isErrorUpdateLanguages: false,
            notification: {
                message: 'Loading ...',
            }
        })
    })

    it('It is expected to return values when the request is fulfilled resolution', () => {
        expect(
            studentLanguages(undefined, {
                type: 'updateProfileLanguagesThunk/fulfilled',
                payload: {
                    languages: {
                        language_id: 'string',
                        language_name: 'string',
                        language_level: 'string',
                    },
                },
            }),
        ).toEqual({
            isLoadingLanguages: false,
            isErrorLanguages: false,
            languagesData: [],
            isOpenEditAdditionalInformation: false,
            isLoadingUpdateLanguages: false,
            isErrorUpdateLanguages: false,
            notification: {
                message: 'Idioma actualitzat correctament',
            }
        })
    })

    it('It is expected to return values when the request is rejected resolution', () => {
        expect(
            studentLanguages(undefined, {
                type: 'updateProfileLanguagesThunk/rejected',
                payload: [],
            }),
        ).toEqual({
            isLoadingLanguages: false,
            isErrorLanguages: false,
            languagesData: [],
            isOpenEditAdditionalInformation: false,
            isLoadingUpdateLanguages: true,
            isErrorUpdateLanguages: true,
            notification: {
                message: 'Estudiant o idioma no trobat',
            }
        })
    })
})