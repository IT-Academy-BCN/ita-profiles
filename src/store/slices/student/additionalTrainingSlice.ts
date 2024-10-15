import { createSlice } from "@reduxjs/toolkit"
import { additionalTrainingThunk } from "../../thunks/getDetailResourceStudentWithIdThunk";

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
    builder.addCase(additionalTrainingThunk.pending, (state) => {
      state.isLoadingAdditionalTraining = true;
      state.isErrorAdditionalTraining = false;
    })

    builder.addCase(additionalTrainingThunk.fulfilled, (state, action) => {
      state.isLoadingAdditionalTraining = false;
      state.isErrorAdditionalTraining = false;
      state.additionalTraining = action.payload.additionalTrainings
    })

    builder.addCase(additionalTrainingThunk.rejected, (state) => {
      state.isLoadingAdditionalTraining = false;
      state.isErrorAdditionalTraining = true;
      state.additionalTraining = []
    })

  },
})


export default additionalTrainingSlice.reducer