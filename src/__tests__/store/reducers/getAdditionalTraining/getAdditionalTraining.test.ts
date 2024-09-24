import { createSlice } from "@reduxjs/toolkit"

const additionalTraining = createSlice({
  name: "additionalTrainingSlice",
  initialState: {
    isLoadingAdditionalTraining: false,
    isErrorAdditionalTrainingData: false,
    additionalTrainingD: {},
  },
  reducers: {},
  extraReducers: {},
})

describe("additionalTraining", () => {
  it("should reducer returned defined", () => {
    expect(additionalTraining.reducer).toBeDefined()
  })
})