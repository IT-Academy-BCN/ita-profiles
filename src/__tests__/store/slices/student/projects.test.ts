import studentProjects from '../../../../store/slices/student/projectsSlice'

export const initialState = {
    isLoadingProjects: false,
    isErrorProjects: false,
    projectsData: [],
    editProjectModalIsOpen: false,
    selectedProjectID: null,
}
describe('Student Projects Test (Redux)', () => {
    it('should be defined Student Projects Slice', () => {
        expect(studentProjects).toBeDefined()
    })

    it('should be defined Student Projects return initialState', () => {
        expect(
            studentProjects(undefined, {
                type: 'object',
                payload: [],
            }),
        ).toEqual({
            ...initialState,
        })
    })

    it('should be projectsThunk/pending return State', () => {
        expect(
            studentProjects(undefined, {
                type: 'projectsThunk/pending',
                payload: [],
            }),
        ).toEqual({
            ...initialState,
            isLoadingProjects: true
        })
    })

    it('should be projectsThunk/fulfilled return State', () => {
        expect(
            studentProjects(undefined, {
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
            isLoadingProjects: false,
            isErrorProjects: false,
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

    it('should be projectsThunk/rejected return State', () => {
        expect(
            studentProjects(undefined, {
                type: 'projectsThunk/rejected',
                payload: [],
            }),
        ).toEqual({
            ...initialState,
            isLoadingProjects: false,
            isErrorProjects: true,
            selectedProjectID: null,
        })
    })
})
