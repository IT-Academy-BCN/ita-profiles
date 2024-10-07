import { createSlice, PayloadAction } from '@reduxjs/toolkit'
/* eslint-disable no-param-reassign */

const initialState = {
    isUserPanelOpen: false,
    filteredStudents: '',
}

const showUserInfo = createSlice({
    name: 'showUserReducer',
    initialState,
    reducers: {
        openUserPanel: (state) => {
            state.isUserPanelOpen = true
        },
        closeUserPanel: (state) => {
            state.isUserPanelOpen = false
        },
        setFilteredStudents: (state, action: PayloadAction<string>) => {
            state.filteredStudents = action.payload
        },
    },
})

export const { openUserPanel, closeUserPanel, setFilteredStudents } =
    showUserInfo.actions

export default showUserInfo.reducer
