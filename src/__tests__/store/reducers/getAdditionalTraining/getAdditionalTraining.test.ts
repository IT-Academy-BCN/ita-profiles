import { TAdditionalTraining } from "../../../../interfaces/interfaces"
import additionalTrainingSlice, { initialState } from "../../../../store/reducers/getAdditionalTraining/studentAdditionalTraining"


describe("additionalTrainingSlice", () => {

  it("should reducer returned defined", () => {
    expect(additionalTrainingSlice).toBeDefined()
  })

  it("should be defined initial State", () => {
    expect(initialState.isLoadingAdditionalTraining).toBeFalsy()
    expect(initialState.isErrorAdditionalTraining).toBeFalsy()
    expect(initialState.additionalTraining).toMatchObject<TAdditionalTraining[]>([])
  })

  it("should be return initialState", () => {
    expect(additionalTrainingSlice(undefined, {
      type: "object",
      payload: [],
    })).toEqual({
      isLoadingAdditionalTraining: false,
      isErrorAdditionalTraining: false,
      additionalTraining: [],
    })
  })

  // Implementar el metedo asyncrono para traer los datos Entrenamiento adicional
  // Implementar los test para la acción get pending 
  it("should be Implement tests for the get pending", () => {
    expect(additionalTrainingSlice(undefined, {
      type: "getStudentAdditionalTrainingThunk/pending",
      payload: [],
    })).toEqual({
      isLoadingAdditionalTraining: true,
      isErrorAdditionalTraining: false,
      additionalTraining: [],
    })
  })
  // Implementar los test para la acción get fulfilled 
  it("should be Implement tests for the get fulfilled", () => {
    expect(additionalTrainingSlice(undefined, {
      type: "getStudentAdditionalTrainingThunk/fulfilled",
      payload: [
        {
          "uuid": "9d159757-2d78-4e32-83f9-8b54ea80b8f1",
          "course_name": "Quia voluptatum neque recusandae.",
          "study_center": "Nienow, Rolfson and Blick",
          "course_beginning_year": 2013,
          "course_ending_year": 2020,
          "duration_hrs": 327
        },
        {
          "uuid": "9d159757-471f-48d5-9fc0-70a3aa3439e6",
          "course_name": "Et accusamus consequatur ad.",
          "study_center": "Konopelski-Toy",
          "course_beginning_year": 2016,
          "course_ending_year": 2016,
          "duration_hrs": 450
        }
      ],
    })).toEqual({
      isLoadingAdditionalTraining: false,
      isErrorAdditionalTraining: false,
      additionalTraining: [
        {
          "uuid": "9d159757-2d78-4e32-83f9-8b54ea80b8f1",
          "course_name": "Quia voluptatum neque recusandae.",
          "study_center": "Nienow, Rolfson and Blick",
          "course_beginning_year": 2013,
          "course_ending_year": 2020,
          "duration_hrs": 327
        },
        {
          "uuid": "9d159757-471f-48d5-9fc0-70a3aa3439e6",
          "course_name": "Et accusamus consequatur ad.",
          "study_center": "Konopelski-Toy",
          "course_beginning_year": 2016,
          "course_ending_year": 2016,
          "duration_hrs": 450
        }
      ],
    })
  })
  // Implementar los test para la acción get rejected
  it("should be Implement tests for the get rejected", () => {
    expect(additionalTrainingSlice(undefined, {
      type: "getStudentAdditionalTrainingThunk/rejected",
      payload: [],
    })).toEqual({
      isLoadingAdditionalTraining: false,
      isErrorAdditionalTraining: true,
      additionalTraining: [],
    })
  })


})
