import { createSlice } from "@reduxjs/toolkit"

const initialState = {
  isLoadingAdditionalTraining: false,
  isErrorAdditionalTrainingData: false,
  additionalTrainingD: {},
}
const additionalTraining = createSlice({
  name: "additionalTrainingSlice",
  initialState,
  reducers: {},
  extraReducers: {},
})

describe("additionalTraining", () => {
  it("should reducer returned defined", () => {
    expect(additionalTraining.reducer).toBeDefined()
  })
  it("should be defined initial State", () => {
    expect(initialState.isLoadingAdditionalTraining).toBeFalsy()
  })
})
