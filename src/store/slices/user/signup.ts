import { ActionCreator, createSlice, PayloadAction } from '@reduxjs/toolkit'
import { registerNewUserThunk, SignUpState } from '../../thunks/registerNewUserThunk'

export type SignUp =
  {
    isErrorCreateUser: boolean,
    isLoadingCreateUser: boolean,
    isSuccessCreateUser: boolean,
    message?: string
  }


const initialState: SignUp = {
  isErrorCreateUser: false,
  isLoadingCreateUser: false,
  isSuccessCreateUser: false,
}
const signUp = createSlice({
  name: 'signUpReducer',
  initialState,
  reducers: {},
  extraReducers: (builder) => {
    builder.addCase(registerNewUserThunk.fulfilled, (state, action) => {
      state.isLoadingCreateUser = false
      state.isErrorCreateUser = false
      state.isSuccessCreateUser = true
      state.message = action.payload.message
      console.log(action.payload)
    })
    builder.addCase(registerNewUserThunk.rejected, (state, action) => {
      state.isLoadingCreateUser = false
      state.isErrorCreateUser = true
      state.isSuccessCreateUser = false
      state.message = "Invalido"
      console.log(action.payload)
    })
    builder.addCase(registerNewUserThunk.pending, (state, action) => {
      state.isLoadingCreateUser = true
      state.isErrorCreateUser = false
      state.isSuccessCreateUser = false
      state.message = "Loading"
      console.log(action.payload)
    })
  }
})

export default signUp.reducer
