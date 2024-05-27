import { createSlice, PayloadAction } from "@reduxjs/toolkit";

const initialState = {
    isUserPanelOpen: false,
    filteredStudents: ''
}

const showUserInfo = createSlice({
    name: "showUserReducer",
    initialState,
    reducers: {
        openUserPanel: (state) => {
            // eslint-disable-next-line no-param-reassign
            state.isUserPanelOpen = true;
        },
        closeUserPanel: (state) => {
            // eslint-disable-next-line no-param-reassign
            state.isUserPanelOpen = false;
        },
        setFilteredStudents: (state, action: PayloadAction<string>) => {
            // eslint-disable-next-line no-param-reassign
            state.filteredStudents = action.payload;
        },
    },
});

export const { openUserPanel, closeUserPanel, setFilteredStudents } = showUserInfo.actions;

export default showUserInfo.reducer;