/* eslint-disable no-param-reassign */
import { createSlice } from "@reduxjs/toolkit"
import { getStudentAdditionalTrainingThunk } from "../../thunks/getDetailResourceStudentWithIdThunk";
// import getStudentAdditionalTrainingThunk from "./studentAdditionalTrainingThunk";

export const initialState = {
  isLoadingAdditionalTraining: false,
  isErrorAdditionalTraining: false,
  additionalTraining: [],
}

const additionalTrainingSlice = createSlice({
  name: "additionalTrainingSlice",
  initialState,
  reducers: {},
  extraReducers: (builder) => {
    builder.addCase(getStudentAdditionalTrainingThunk.pending, (state) => {
      state.isLoadingAdditionalTraining = true;
      state.isErrorAdditionalTraining = false;
    })

    builder.addCase(getStudentAdditionalTrainingThunk.fulfilled, (state, action) => {
      state.isLoadingAdditionalTraining = false;
      state.isErrorAdditionalTraining = false;
      state.additionalTraining = action.payload.additional_trainings
    })

    builder.addCase(getStudentAdditionalTrainingThunk.rejected, (state) => {
      state.isLoadingAdditionalTraining = false;
      state.isErrorAdditionalTraining = true;
      state.additionalTraining = []
    })

  },
})


export default additionalTrainingSlice.reducer