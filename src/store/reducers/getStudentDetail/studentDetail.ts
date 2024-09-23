/* eslint-disable no-param-reassign */

import { createSlice } from "@reduxjs/toolkit";
import { TAbout } from "../../../interfaces/interfaces";
import getStudentDetail from "./studentDetailThunk";

const aboutData: TAbout = {
    id: 0,
    fullname: '',
    subtitle: '',
    social_media: {
        github: {
            url: ''
        },
        linkedin: {
            url: ''
        }
    },
    about: '',
    photo: '',
    tags: []
}

const studentDetail = createSlice({
    name: "studentDetailSlice",
    initialState: {
        isLoadindAboutData: false,
        isErrorAboutData: false,
        aboutData
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(getStudentDetail.pending, (state) => {
            state.isLoadindAboutData = true
            state.isErrorAboutData = false
        })
        builder.addCase(getStudentDetail.fulfilled, (state, action) => {
            state.aboutData = action.payload
            state.isLoadindAboutData = false
            state.isErrorAboutData = false
        })
        builder.addCase(getStudentDetail.rejected, (state) => {
            state.isLoadindAboutData = false
            state.isErrorAboutData = true
        })
    }
});

export default studentDetail.reducer;
