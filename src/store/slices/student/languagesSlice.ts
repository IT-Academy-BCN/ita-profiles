import { createSlice } from '@reduxjs/toolkit'
import { TLanguage } from '../../../interfaces/interfaces'
import { languagesThunk } from '../../thunks/getDetailResourceStudentWithIdThunk'

const languagesData: TLanguage[] = []

const languagesSlice = createSlice({
    name: 'languagesSlice',
    initialState: {
        isLoadingLanguages: false,
        isErrorLanguages: false,
        languagesData,
        isOpenEditAdditionalInformation: false
    },
    reducers: {
        toggleEditAdditionalInformation: (state) => {
            state.isOpenEditAdditionalInformation = !state.isOpenEditAdditionalInformation
        },
        setLanguagesData: (state, action) => {
            state.languagesData = action.payload
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
    },
})
export const { toggleEditAdditionalInformation, setLanguagesData } = languagesSlice.actions
export default languagesSlice.reducer
