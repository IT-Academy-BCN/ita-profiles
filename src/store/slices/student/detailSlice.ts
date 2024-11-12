import { createSlice } from '@reduxjs/toolkit'
import { TAbout } from '../../../interfaces/interfaces'
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
    toggleProfileImage: false,
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
        resetSendingPhoto: (state) => {
            state.isLoadingPhoto = false
            state.isErrorPhoto = false
            state.photoSuccessfully = false
        },
        setMessage: (state, action) => {
            state.updatedMessage = action.payload
        },
        updateTags: (state, action) => {
            if (action.payload) {
                state.aboutData.tags = action.payload || []
            } else {
              console.error("Payload is undefined in updateTags");
              state.aboutData.tags = [];
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
        builder.addCase(updateProfilePhotoThunk.pending, (state) => {
            state.isLoadingPhoto = true
            state.isErrorPhoto = false
            state.photoSuccessfully = false
        })
        builder.addCase(updateProfilePhotoThunk.fulfilled, (state) => {
            state.isLoadingPhoto = false
            state.isErrorPhoto = false
            state.photoSuccessfully = true
        })
        builder.addCase(updateProfilePhotoThunk.rejected, (state) => {
            state.isLoadingPhoto = false
            state.isErrorPhoto = true
            state.photoSuccessfully = false
        });
    },
})

export const { setToggleProfileImage } = detailSlice.actions
export const { updateTags } = detailSlice.actions;


export default detailSlice.reducer
