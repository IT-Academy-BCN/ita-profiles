import { configureStore } from '@reduxjs/toolkit'
import ShowUserReducer from './reducers/getUserDetail/apiGetUserDetail'
import ShowStudenDetails from './reducers/getStudenDetail/studenDetail'

export const store = configureStore({
  reducer: {
    ShowUserReducer,
    ShowStudenDetails
  },
})

// Infer the `RootState` and `AppDispatch` types from the store itself
export type RootState = ReturnType<typeof store.getState>
// Inferred type: {posts: PostsState, comments: CommentsState, users: UsersState}
export type AppDispatch = typeof store.dispatch
