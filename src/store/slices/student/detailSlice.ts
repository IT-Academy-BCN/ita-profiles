import { createSlice } from '@reduxjs/toolkit'
import { TAbout } from '../../../interfaces/interfaces'
import { detailThunk } from '../../thunks/getDetailResourceStudentWithIdThunk'
import { updateProfilePhotoThunk } from '../../thunks/updateProfilePhotoThunk'

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
        sendingPhoto: false,
        errorSendingPhoto: false,
        photoSentSuccessfully: false
    },
    reducers: {
        setToggleProfileImage: (state, action) => {
            state.toggleProfileImage = action.payload
            state.sendingPhoto = false
            state.errorSendingPhoto = false
            state.photoSentSuccessfully = false
        },
        resetSendingPhoto: (state) => {
            state.sendingPhoto = false
            state.errorSendingPhoto = false
            state.photoSentSuccessfully = false
        }

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

        builder.addCase(updateProfilePhotoThunk.pending, (state) => {
            state.sendingPhoto = true
            state.errorSendingPhoto = false
            state.photoSentSuccessfully = false
        })
        builder.addCase(updateProfilePhotoThunk.fulfilled, (state, action) => {
            state.aboutData.photo = action.payload
            state.sendingPhoto = false
            state.errorSendingPhoto = false
            state.photoSentSuccessfully = true
        })
        builder.addCase(updateProfilePhotoThunk.rejected, (state) => {
            state.sendingPhoto = false
            state.errorSendingPhoto = true
            state.photoSentSuccessfully = false
        })
    },
})

export const { setToggleProfileImage, resetSendingPhoto } = detailSlice.actions

export default detailSlice.reducer
