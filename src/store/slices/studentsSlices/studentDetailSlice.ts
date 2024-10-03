/* eslint-disable no-param-reassign */

import { createSlice } from '@reduxjs/toolkit'
import { TAbout } from '../../../interfaces/interfaces'
import { getStudentDetailThunk } from '../../thunks/studentDetailThunkWithID'
// import getStudentDetailThunk from "./studentDetailThunk";

const aboutData: TAbout = {
    id: 0,
    fullname: '',
    resume: {
        subtitle: '',
        social_media: {
            github: {
                url: '',
            },
            linkedin: {
                url: '',
            },
        },
        about: '',
    },
    photo: '',
    tags: [],
}

const studentDetailSlice = createSlice({
    name: 'studentDetailSlice',
    initialState: {
        isLoadingAboutData: false,
        isErrorAboutData: false,
        aboutData,
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(getStudentDetailThunk.pending, (state) => {
            state.isLoadingAboutData = true
            state.isErrorAboutData = false
        })
        builder.addCase(getStudentDetailThunk.fulfilled, (state, action) => {
            state.aboutData = action.payload
            state.isLoadingAboutData = false
            state.isErrorAboutData = false
        })
        builder.addCase(getStudentDetailThunk.rejected, (state) => {
            state.isLoadingAboutData = false
            state.isErrorAboutData = true
        })
    },
})

export default studentDetailSlice.reducer
