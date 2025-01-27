import { combineReducers, configureStore } from '@reduxjs/toolkit'
import userSlice from './slices/user/details'
import detailSlice from './slices/student/detailSlice'
import projectsSlice from './slices/student/projectsSlice'
import collaborationsSlice from './slices/student/collaborationsSlice'
import bootcampSlice from './slices/student/bootcampSlice'
import languagesSlice from './slices/student/languagesSlice'
import additionalTrainingSlice from './slices/student/additionalTrainingSlice'
import modalitySlice from './slices/student/modalitySlice'
import registerNewUserSlice from './slices/user/signup'



export const store = configureStore({
    reducer: {
        ShowUserReducer: combineReducers({
            user: userSlice,
            createUser: registerNewUserSlice
        }),
        ShowStudentReducer: combineReducers({
            studentDetails: detailSlice,
            studentProjects: projectsSlice,
            studentCollaborations: collaborationsSlice,
            studentBootcamps: bootcampSlice,
            studentLanguages: languagesSlice,
            studentAdditionalTraining: additionalTrainingSlice,
            studentAdditionalModality: modalitySlice,

        })
    },
})

// Infer the `RootState` and `AppDispatch` types from the store itself
export type RootState = ReturnType<typeof store.getState>
// Inferred type: {posts: PostsState, comments: CommentsState, users: UsersState}
export type AppDispatch = typeof store.dispatch
