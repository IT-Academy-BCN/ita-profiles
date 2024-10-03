import { combineReducers, configureStore } from '@reduxjs/toolkit'
import ShowUserReducer from './slices/userSlice/apiGetUserDetail'
import studentDetailSlice from './slices/studentsSlices/studentDetailSlice'
import ShowStudentProjects from './slices/studentsSlices/studentProjectsSlice'
import studentCollaborationsSlice from './slices/studentsSlices/studentCollaborationsSlice'
import studentBootcampSlice from './slices/studentsSlices/studentBootcampSlice'
import studentLanguagesSlice from './slices/studentsSlices/studentLanguagesSlice'
import studentAdditionalTrainingSlice from './slices/studentsSlices/studentAdditionalTrainingSlice'
import studentModalitySlice from './slices/studentsSlices/studentModalitySlice'

const student = combineReducers({
    studentDetails: studentDetailSlice,
    studentProjects: ShowStudentProjects,
    studentCollaborations: studentCollaborationsSlice,
    studentBootcamps: studentBootcampSlice,
    studentLanguages: studentLanguagesSlice,
    studentAdditionalTraining: studentAdditionalTrainingSlice,
    studentAdditionalModality: studentModalitySlice,
})

export const store = configureStore({
    reducer: {
        ShowUserReducer,
        ShowStudentReducer: student,
    },
})

// Infer the `RootState` and `AppDispatch` types from the store itself
export type RootState = ReturnType<typeof store.getState>
// Inferred type: {posts: PostsState, comments: CommentsState, users: UsersState}
export type AppDispatch = typeof store.dispatch
