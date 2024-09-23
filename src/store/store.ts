import { combineReducers, configureStore } from '@reduxjs/toolkit'
import ShowUserReducer from './reducers/getUserDetail/apiGetUserDetail'
import ShowStudentDetails from './reducers/getStudentDetail/studentDetail'
import ShowStudentProjects from './reducers/getStudentProjects/studentProjects'
import ShowStudentCollaborations from './reducers/getStudentCollaborations/studentCollaborations'
import ShowStudentBootcamps from './reducers/getStudentBootcamp/studentBootcamp'
import ShowStudentLanguages from './reducers/getStudentLanguages/studentLanguages'

const student = combineReducers({
  studentDetails: ShowStudentDetails,
  studentProjects: ShowStudentProjects,
  studentCollaborations: ShowStudentCollaborations,
  studentBootcamps: ShowStudentBootcamps,
  studentLanguages: ShowStudentLanguages,
})

export const store = configureStore({
  reducer: {
    ShowUserReducer,
    ShowStudentReducer: student
  },
})

// Infer the `RootState` and `AppDispatch` types from the store itself
export type RootState = ReturnType<typeof store.getState>
// Inferred type: {posts: PostsState, comments: CommentsState, users: UsersState}
export type AppDispatch = typeof store.dispatch
