import { createSlice } from '@reduxjs/toolkit'
import { TInitialStateLanguageSlice } from '../../../interfaces/interfaces'
import { languagesThunk } from '../../thunks/getDetailResourceStudentWithIdThunk'
import { updateProfileLanguagesThunk } from '../../thunks/updateProfileLanguagesThunk'

const languagesData: TLanguage[] = []

const languagesSlice = createSlice({
    name: 'languagesSlice',
    initialState: {
        isLoadingLanguages: false,
        isErrorLanguages: false,
        languagesData,
        isOpenEditAdditionalInformation: false,
        isLoadingUpdateLanguages: false,
        isErrorUpdateLanguages: false,
        notification: {
            message: '',
        }
    },
    reducers: {
        toggleEditAdditionalInformation: (state) => {
            state.isOpenEditAdditionalInformation = !state.isOpenEditAdditionalInformation
        },
        setLanguagesData: (state, action) => {
            state.languagesData = action.payload
        },
        resetUpdateLanguages: (state) => {
            state.isLoadingUpdateLanguages = false;
            state.isErrorUpdateLanguages = false;
            state.isOpenEditAdditionalInformation = false;
            state.notification.message = '';
        }
    },
    extraReducers: (builder) => {
        builder.addCase(languagesThunk.pending, (state) => {
            state.isLoadingLanguages = true
            state.isErrorLanguages = false
        })
        builder.addCase(languagesThunk.fulfilled, (state, action) => {
            state.languagesData = action.payload.languages
            state.isLoadingLanguages = false
            state.isErrorLanguages = false
        })
        builder.addCase(languagesThunk.rejected, (state) => {
            state.isLoadingLanguages = false
            state.isErrorLanguages = true
        })

        builder.addCase(updateProfileLanguagesThunk.pending, (state) => {
            state.isLoadingUpdateLanguages = true;
            state.isErrorUpdateLanguages = false;
            state.notification = {
                message: 'Loading ...',
            }
        })
        builder.addCase(updateProfileLanguagesThunk.fulfilled, (state, action) => {
            state.isLoadingUpdateLanguages = false;
            state.isErrorUpdateLanguages = false;
            // Idioma actualitzat correctament
            state.notification = {
                message: action.payload.message ?? 'Idioma actualitzat correctament'
            }
        })
        builder.addCase(updateProfileLanguagesThunk.rejected, (state) => {
            state.isLoadingUpdateLanguages = true;
            state.isErrorUpdateLanguages = true;
            state.notification = {
                message: "Estudiant o idioma no trobat",
            }
        })
    },
})
export const { toggleEditAdditionalInformation, setLanguagesData, resetUpdateLanguages } = languagesSlice.actions
export default languagesSlice.reducer
