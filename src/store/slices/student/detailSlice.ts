import { createSlice } from '@reduxjs/toolkit'
import { TAbout } from '../../../interfaces/interfaces'
import { detailThunk } from '../../thunks/getDetailResourceStudentWithIdThunk'

const aboutData: TAbout = {
    id: 0,
    fullname: '',
    resume: {
        subtitle: '',
        social_media: {
            github: '',

            linkedin: '',
        },

        about: '',
    },
    photo: '',
    tags: [],
}

const detailSlice = createSlice({
    name: 'detailSlice',
    initialState: {
        isLoadingAboutData: false,
        isErrorAboutData: false,
        aboutData,
        toggleProfileImage: false,
    },
    reducers: {
        setToggleProfileImage: (state, action) => {
            state.toggleProfileImage = action.payload
        },
    },
    extraReducers: (builder) => {
        builder.addCase(detailThunk.pending, (state) => {
            state.isLoadingAboutData = true
            state.isErrorAboutData = false
        })
        builder.addCase(detailThunk.fulfilled, (state, action) => {
            state.aboutData = action.payload
            state.isLoadingAboutData = false
            state.isErrorAboutData = false
        })
        builder.addCase(detailThunk.rejected, (state) => {
            state.isLoadingAboutData = false
            state.isErrorAboutData = true
        })
    },
})

export const { setToggleProfileImage } = detailSlice.actions

export default detailSlice.reducer
