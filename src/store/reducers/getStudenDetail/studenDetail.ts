/* eslint-disable no-param-reassign */

import { createSlice } from "@reduxjs/toolkit";
import { TAbout } from "../../../interfaces/interfaces";
import getStudenDetail from "./thunks/studenDetailThunk";

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



const studenDetail = createSlice({
    name: "studenDetailSlice",
    initialState: {
        isLoadindAboutData: false,
        isErrorAboutData: false,
        aboutData
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(getStudenDetail.pending, (state) => {
            state.isLoadindAboutData = true
            state.isErrorAboutData = false
        })
        builder.addCase(getStudenDetail.fulfilled, (state, action) => {
            state.aboutData = action.payload
            state.isLoadindAboutData = false
            state.isErrorAboutData = false
        })
        builder.addCase(getStudenDetail.rejected, (state) => {
            state.isLoadindAboutData = false
            state.isErrorAboutData = true
        })
    }
});

export default studenDetail.reducer;