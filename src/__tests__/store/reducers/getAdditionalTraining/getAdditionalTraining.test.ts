import { createSlice } from "@reduxjs/toolkit"
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
  extraReducers: {},
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

})
