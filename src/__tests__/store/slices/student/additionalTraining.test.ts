import { TAdditionalTraining } from '../../../../interfaces/interfaces'
import additionalTrainingSlice, {
    initialState,
} from '../../../../store/slices/student/additionalTrainingSlice'

describe('additionalTrainingSlice', () => {
    it('should reducer returned defined', () => {
        expect(additionalTrainingSlice).toBeDefined()
    })

    it('should be defined initial State', () => {
        expect(initialState.isLoadingAdditionalTraining).toBeFalsy()
        expect(initialState.isErrorAdditionalTraining).toBeFalsy()
        expect(initialState.additionalTraining).toMatchObject<
            TAdditionalTraining[]
        >([])
    })

    it('should be return initialState', () => {
        expect(
            additionalTrainingSlice(undefined, {
                type: 'object',
                payload: [],
            }),
        ).toEqual({
            isLoadingAdditionalTraining: false,
            isErrorAdditionalTraining: false,
            additionalTraining: [],
        })
    })

    it('should be Implement tests for the get pending', () => {
        expect(
            additionalTrainingSlice(undefined, {
                type: 'additionalTrainingThunk/pending',
                payload: [],
            }),
        ).toEqual({
            isLoadingAdditionalTraining: true,
            isErrorAdditionalTraining: false,
            additionalTraining: [],
        })
    })

    it('should be Implement tests for the get fulfilled', () => {
        expect(
            additionalTrainingSlice(undefined, {
                type: 'additionalTrainingThunk/fulfilled',
                payload: {
                    additional_trainings: [
                        {
                            uuid: '3fa85f64-5717-4562-b3fc-2c963f66afa6',
                            course_name: 'string',
                            study_center: 'string',
                            course_beginning_year: 0,
                            course_ending_year: 0,
                            duration_hrs: 0,
                        },
                    ],
                },
            }),
        ).toEqual({
            isLoadingAdditionalTraining: false,
            isErrorAdditionalTraining: false,
            additionalTraining: [
                {
                    uuid: '3fa85f64-5717-4562-b3fc-2c963f66afa6',
                    course_name: 'string',
                    study_center: 'string',
                    course_beginning_year: 0,
                    course_ending_year: 0,
                    duration_hrs: 0,
                },
            ],
        })
    })

    it('should be Implement tests for the get rejected', () => {
        expect(
            additionalTrainingSlice(undefined, {
                type: 'additionalTrainingThunk/rejected',
                payload: [],
            }),
        ).toEqual({
            isLoadingAdditionalTraining: false,
            isErrorAdditionalTraining: true,
            additionalTraining: [],
        })
    })
})
