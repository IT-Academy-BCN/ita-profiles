import { TypedUseSelectorHook, useDispatch, useSelector } from 'react-redux'
import type { RootState, AppDispatch } from "../store/store"

// Use throughout your app instead of plain `useDispatch` and `useSelector`. More info here ->
// https://redux.js.org/tutorials/typescript-quick-start

export const useAppDispatch: () => AppDispatch = useDispatch
export const useAppSelector: TypedUseSelectorHook<RootState> = useSelector

// Lo que hace esto ejemplo:

// * En vez de:

// const { loading } = useSelector(
//  (state: RootState) => state.getCollaboratorsFunctionality
//  ); 

// * hacemos: 

//  const { loading } = useAppSelector(
//   (state) => state.getCollaboratorsFunctionality
//  );