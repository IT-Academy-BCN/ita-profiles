import { createSlice } from "@reduxjs/toolkit";
import { TAbout } from "../../../../interfaces/interfaces";

const aboutData: TAbout = {
    id: 0,
    fullname: '',
    resume: {
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
    },
    photo: '',
    tags: []
}

const studentDetail = createSlice({
    name: "studentDetailSlice",
    initialState: {
        isLoadingAboutData: false,
        isErrorAboutData: false,
        aboutData
    },
    reducers: {}
})
describe("studentDetail", () => {
    it("should reducer return defined", () => {
        expect(studentDetail.reducer).toBeDefined();
    })
})