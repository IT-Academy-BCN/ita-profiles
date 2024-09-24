import { createAsyncThunk, createSlice } from "@reduxjs/toolkit"
import { TAdditionalTraining } from "../../../../interfaces/interfaces"

const initialState = {
  isLoadingAdditionalTraining: false,
  isErrorAdditionalTraining: false,
  additionalTraining: [],
}

const additionalTraining = createSlice({
  name: "additionalTrainingSlice",
  initialState,
  reducers: {},
  extraReducers: (builder) => {
    builder.addCase(createAsyncThunk("getdditionalTrainingThunk", async () => { }).pending, (state) => {
      state.isLoadingAdditionalTraining = true;
      state.isErrorAdditionalTraining = false;
    })
  },
})

describe("additionalTraining", () => {

  it("should reducer returned defined", () => {
    expect(additionalTraining.reducer).toBeDefined()
  })

  it("should be defined initial State", () => {
    expect(initialState.isLoadingAdditionalTraining).toBeFalsy()
    expect(initialState.isErrorAdditionalTraining).toBeFalsy()
    expect(initialState.additionalTraining).toMatchObject<TAdditionalTraining[]>([])
  })

  it("should be return initialState", () => {
    expect(additionalTraining.reducer(undefined, {
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
    expect(additionalTraining.reducer(undefined, {
      type: "getdditionalTrainingThunk/pending",
      payload: [],
    })).toEqual({
      isLoadingAdditionalTraining: true,
      isErrorAdditionalTraining: false,
      additionalTraining: [],
    })
  })
  // Implementar los test para la acción get fullfilled 
  it("should be Implement tests for the get fullfilled", () => {
    expect(undefined).toBeDefined()
  })
  // Implementar los test para la acción get reject
  it("should be Implement tests for the get reject", () => {
    expect(undefined).toBeDefined()
  })


})
