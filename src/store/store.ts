import { combineReducers, configureStore } from '@reduxjs/toolkit'
import ShowUserReducer from './reducers/getUserDetail/apiGetUserDetail'
import ShowStudenDetails from './reducers/getStudenDetail/studenDetail'
import ShowStudenProjects from './reducers/getStudenProjects/studenProjects'
import ShowStudentCollaborations from './reducers/getStudentCollaborations/studentCollaborations'

const studen = combineReducers({
  studenDetails: ShowStudenDetails,
  studenProjects: ShowStudenProjects,
  studentCollaborations: ShowStudentCollaborations
})

export const store = configureStore({
  reducer: {
    ShowUserReducer,
    ShowStudenReducer: studen
  },
})

// Infer the `RootState` and `AppDispatch` types from the store itself
export type RootState = ReturnType<typeof store.getState>
// Inferred type: {posts: PostsState, comments: CommentsState, users: UsersState}
export type AppDispatch = typeof store.dispatch
