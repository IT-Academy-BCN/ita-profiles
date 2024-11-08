import { createSlice } from '@reduxjs/toolkit'
import { TAbout } from '../../../../types'
import {
    detailThunk,
    updateDetailThunk,
} from '../../thunks/getDetailResourceStudentWithIdThunk'
import { updateProfilePhotoThunk } from '../../thunks/updateProfilePhotoThunk'

const aboutData: TAbout = {
    id: 0,
    name: '',
    surname: '',
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
export const initialState = {
    isLoadingAboutData: false,
    isErrorAboutData: false,
    aboutData,
    editProfileImageIsOpen: false,
    editProfileModalIsOpen: false,
    updatedMessage: '',
    updatedError: '',
    isUpdateLoading: false,
    isLoadingPhoto: false,
    isErrorPhoto: false,
    photoSuccessfully: false
}

const detailSlice = createSlice({
    name: 'detailSlice',
    initialState,
    reducers: {
        setToggleProfileImage: (state, action) => {
            state.toggleProfileImage = action.payload
        },
        updateTags: (state, action) => {
            if (action.payload) {
                state.aboutData.tags = action.payload || []
            } else {
                console.error('Payload is undefined in updateTags')
                state.aboutData.tags = []
            }
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
        builder.addCase(updateDetailThunk.pending, (state) => {
            state.isUpdateLoading = true
            state.updatedError = ''
            state.updatedMessage = ''
        })
        builder.addCase(updateDetailThunk.fulfilled, (state) => {
            state.updatedMessage = 'El usuario fue actualizado con éxito!'
            state.updatedError = ''
            state.isUpdateLoading = false
        })
        builder.addCase(updateDetailThunk.rejected, (state) => {
            state.updatedMessage = ''
            state.updatedError = 'Error al realizar la actualizacion del perfil'
            state.isUpdateLoading = false
        })
    },
})

export const { setToggleProfileImage } = detailSlice.actions
export const { updateTags } = detailSlice.actions

export default detailSlice.reducer
