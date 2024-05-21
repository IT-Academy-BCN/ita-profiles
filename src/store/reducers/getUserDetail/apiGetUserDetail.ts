import { createSlice, PayloadAction } from "@reduxjs/toolkit";

const initialState = {
    isUserPanelOpen: false,
    filteredStudents: ''
}

const showUserInfo = createSlice({
    name: "showUserReducer",
    initialState,
    reducers: {
        toggleUserPanel: (state) => {
            // eslint-disable-next-line no-param-reassign
            state.isUserPanelOpen = !state.isUserPanelOpen;
        },
        setFilteredStudents: (state, action: PayloadAction<string>) => {
            // eslint-disable-next-line no-param-reassign
            state.filteredStudents = action.payload;
        }  
    }
})

export const { toggleUserPanel, setFilteredStudents  } = showUserInfo.actions;
export default showUserInfo.reducer;