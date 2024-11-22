import studentProjects, {
    initialState,
} from '../../../../store/slices/student/projectsSlice'

describe('Student Projects Test (Redux)', () => {
    it('should be defined Student Projects Slice', () => {
        expect(studentProjects).toBeDefined()
    })

    it('should return initialState', () => {
        expect(
            studentProjects(initialState, {
                type: 'object',
                payload: [],
            }),
        ).toEqual({
            ...initialState,
        })
    })

    it('projectThunk/pending  should return  inLoadingProject : true', () => {
        expect(
            studentProjects(initialState, {
                type: 'projectsThunk/pending',
                payload: [],
            }),
        ).toEqual({
            ...initialState,
            isLoadingProjects: true,
        })
    })

    it('projectsThunk/fulfilled should return data', () => {
        expect(
            studentProjects(initialState, {
                type: 'projectsThunk/fulfilled',
                payload: {
                    projects: [
                        {
                            uuid: '9becbb14-0267-409b-9c77-9377ce67c9cf',
                            project_name: 'ITA Profiles',
                            company_name: 'Barcelona Activa',
                            project_url: 'https://www.ita-profiles.com',
                            tags: [
                                {
                                    id: 7,
                                    name: 'Bootstrap',
                                },
                            ],
                            project_repository: 'string',
                        },
                    ],
                },
            }),
        ).toEqual({
            ...initialState,
            projectsData: [
                {
                    uuid: '9becbb14-0267-409b-9c77-9377ce67c9cf',
                    project_name: 'ITA Profiles',
                    company_name: 'Barcelona Activa',
                    project_url: 'https://www.ita-profiles.com',
                    tags: [
                        {
                            id: 7,
                            name: 'Bootstrap',
                        },
                    ],
                    project_repository: 'string',
                },
            ],
            selectedProjectID: null,
        })
    })

    it('projectsThunk/rejected should return errorProject : true ', () => {
        expect(
            studentProjects(initialState, {
                type: 'projectsThunk/rejected',
                payload: [],
            }),
        ).toEqual({
            ...initialState,
            isErrorProjects: true,
        })
    })

    it('updateProjectsThunk/pending  should return  isLoadingUpdateProjects : true', () => {
        expect(
            studentProjects(initialState, {
                type: 'updateProjectsThunk/pending',
                payload: [],
            }),
        ).toEqual({
            ...initialState,
            isLoadingUpdateProjects: true,
        })
    })

    it('updateProjectsThunk/rejected  should return  isErrorUpdateProjects : true', () => {
        expect(
            studentProjects(initialState, {
                type: 'updateProjectsThunk/rejected',
                payload: [],
            }),
        ).toEqual({
            ...initialState,
            isLoadingUpdateProjects: false,
            isErrorUpdateProjects: true,
        })
    })

    it('updateProjectsThunk/fulfilled  should return  isSuccessUpdateProjects : true', () => {
        expect(
            studentProjects(initialState, {
                type: 'updateProjectsThunk/fulfilled',
                payload: [],
            }),
        ).toEqual({
            ...initialState,
            isLoadingUpdateProjects: false,
            isSuccessUpdateProjects: true,
        })
    })
})
