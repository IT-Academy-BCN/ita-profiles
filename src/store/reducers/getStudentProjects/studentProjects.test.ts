/* eslint-disable no-param-reassign */
import { createSlice } from "@reduxjs/toolkit";
import getStudentProjectsThunk from "./studentProjectsThunk";
import { TProject } from "../../../interfaces/interfaces";

const projectsData: TProject[] = [];

const StudentProjectsSlice = createSlice({
    name: "studentProjectsSlice",
    initialState: {
        isLoadingProjects: false,
        isErrorProjects: false,
        projectsData
    },
    reducers: {},
    extraReducers: (builder) => {
        builder.addCase(getStudentProjectsThunk.pending, (state) => {
            state.isLoadingProjects = true
            state.isErrorProjects = false
        })
        builder.addCase(getStudentProjectsThunk.fulfilled, (state, action) => {
            state.projectsData = action.payload
            state.isLoadingProjects = false
            state.isErrorProjects = false
        })
        builder.addCase(getStudentProjectsThunk.rejected, (state) => {
            state.isLoadingProjects = false
            state.isErrorProjects = true
        })
    }
});


describe("Student Projects Test (Redux)", () => {
    // should be defined Student Projects Slice
    it("should be defined Student Projects Slice", () => {
        expect(StudentProjectsSlice).toBeDefined();
    })

    it("should be defined Student Projects return initialState", () => {
        expect(StudentProjectsSlice.reducer(undefined, {
            type: "object",
            payload: []
        })).toEqual({
            isLoadingProjects: false,
            isErrorProjects: false,
            projectsData: []
        });
    })

    it("should be defined Student Projects getStudentProjectsThunk/pending", () => {
        expect(StudentProjectsSlice.reducer(undefined, {
            type: "getStudentProjectsThunk/pending",
            payload: []
        })).toEqual({
            isLoadingProjects: true,
            isErrorProjects: false,
            projectsData: []
        });
    })

    it("should be defined Student Projects getStudentProjectsThunk/fulfilled", () => {
        expect(StudentProjectsSlice.reducer(undefined, {
            type: "getStudentProjectsThunk/fulfilled",
            payload: [
                {
                    projects: [
                        {
                            uuid: "9becbb14-0267-409b-9c77-9377ce67c9cf",
                            project_name: "ITA Profiles",
                            company_name: "Barcelona Activa",
                            project_url: "https://www.ita-profiles.com",
                            tags: [
                                {
                                    id: 7,
                                    name: "Bootstrap"
                                }
                            ],
                            project_repository: "string"
                        }
                    ]
                }
            ]
        })).toEqual({
            isLoadingProjects: false,
            isErrorProjects: false,
            projectsData: [
                {
                    projects: [
                        {
                            uuid: "9becbb14-0267-409b-9c77-9377ce67c9cf",
                            project_name: "ITA Profiles",
                            company_name: "Barcelona Activa",
                            project_url: "https://www.ita-profiles.com",
                            tags: [
                                {
                                    id: 7,
                                    name: "Bootstrap"
                                }
                            ],
                            project_repository: "string"
                        }
                    ]
                }
            ]
        });
    })
})
