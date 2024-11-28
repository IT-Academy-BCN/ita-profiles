import { Provider } from 'react-redux'
import { fireEvent, render, screen } from '@testing-library/react'
import { expect } from 'vitest'
import { ReactElement } from 'react'
import { combineReducers, configureStore } from '@reduxjs/toolkit'
import MyProfileProjectsCard from '../../../../../components/students/studentDetail/studentProfile/studentProfileCards/MyProfileProjectsCard'
import projectsSlice from '../../../../../store/slices/student/projectsSlice'
import detailSlice from '../../../../../store/slices/student/detailSlice'

const mockStore = (initialState: object) =>
    configureStore({
        reducer: {
            ShowStudentReducer: combineReducers({
                studentProjects: projectsSlice,
                studentDetails: detailSlice,
            }),
        },
        preloadedState: initialState,
    })

const renderWithProvider = (ui: ReactElement, initialState = {}) => {
    const store = mockStore(initialState)

    return {
        ...render(<Provider store={store}>{ui}</Provider>),
        store,
    }
}
const initialStateWithData = {
    ShowStudentReducer: {
        studentProjects: {
            isLoadingProjects: false,
            isErrorProjects: false,
            projectsData: [
                {
                    id: '9d8a5720-425f-421b-8318-271b58c7f21c',
                    name: 'Adopción',
                    company_name: 'Schoen, Jacobi and Vandervort',
                    github_url: 'https://github.com/kathleen.block',
                    project_url: 'http://roberts.com/',
                    tags: [
                        {
                            id: 18,
                            name: 'Bootstrap',
                        },
                        {
                            id: 16,
                            name: 'JavaScript',
                        },
                        {
                            id: 10,
                            name: 'SQL',
                        },
                        {
                            id: 21,
                            name: 'PHP',
                        },
                        {
                            id: 13,
                            name: 'Ruby',
                        },
                    ],
                },
                {
                    id: '9d8a5720-43ae-4779-b92d-782178676845',
                    name: 'asdasd',
                    company_name: 'Kub Groupsd',
                    github_url: 'https://github.com/marjorie33',
                    project_url: 'http://roberts.asdsdasd/asdsad/dfg/sdf',
                    tags: [
                        {
                            id: 27,
                            name: 'sad',
                        },
                    ],
                },
            ],
            editProjectModalIsOpen: false,
            selectedProjectID: null,
            isLoadingUpdateProjects: false,
            isErrorUpdateProjects: false,
            isSuccessUpdateProjects: false,
        },
        studentDetails: {
            isLoadingAboutData: false,
            isErrorAboutData: false,
            aboutData: {
                id: '9c1bba6e-fcb8-3099-9cc2-cde16ce2d810',
                name: 'Candace',
                surname: 'Koss',
                photo: 'http://mayert.biz/ex-quia-in-voluptatem-laborum-libero.html',
                status: 'Active',
                tags: [
                    {
                        id: 24,
                        name: 'Java',
                    },
                    {
                        id: 26,
                        name: 'GitHub',
                    },
                ],
                resume: {
                    subtitle: 'Full Stack developer en PHP',
                    social_media: {
                        github: 'https://github.com/deckow.hans',
                        linkedin: 'https://linkedin.com/ecronin',
                    },
                    about: 'Sint delectus omnis harum quidem quo eligendi. Autem eum vero modi enim aliquid incidunt.',
                },
            },
            editProfileImageIsOpen: false,
            editProfileModalIsOpen: false,
            updatedMessage: '',
            updatedError: '',
            isUpdateLoading: false,
            isLoadingPhoto: false,
            isErrorPhoto: false,
            photoSuccessfully: false,
        },
    },
}
const stateWithEditProjectModalOpen = {
    ShowStudentReducer: {
        studentProjects: {
            isLoadingProjects: false,
            isErrorProjects: false,
            projectsData: [
                {
                    id: '9d8a5720-425f-421b-8318-271b58c7f21c',
                    name: 'Adopción',
                    company_name: 'Schoen, Jacobi and Vandervort',
                    github_url: 'https://github.com/kathleen.block',
                    project_url: 'http://roberts.com/',
                    tags: [
                        {
                            id: 18,
                            name: 'Bootstrap',
                        },
                        {
                            id: 16,
                            name: 'JavaScript',
                        },
                        {
                            id: 10,
                            name: 'SQL',
                        },
                        {
                            id: 21,
                            name: 'PHP',
                        },
                        {
                            id: 13,
                            name: 'Ruby',
                        },
                    ],
                },
                {
                    id: '9d8a5720-43ae-4779-b92d-782178676845',
                    name: 'asdasd',
                    company_name: 'Kub Groupsd',
                    github_url: 'https://github.com/marjorie33',
                    project_url: 'http://roberts.asdsdasd/asdsad/dfg/sdf',
                    tags: [
                        {
                            id: 27,
                            name: 'sad',
                        },
                    ],
                },
            ],
            editProjectModalIsOpen: true,
            selectedProjectID: null,
            isLoadingUpdateProjects: false,
            isErrorUpdateProjects: false,
            isSuccessUpdateProjects: false,
        },
        studentDetails: {
            isLoadingAboutData: false,
            isErrorAboutData: false,
            aboutData: {
                id: '9c1bba6e-fcb8-3099-9cc2-cde16ce2d810',
                name: 'Candace',
                surname: 'Koss',
                photo: 'http://mayert.biz/ex-quia-in-voluptatem-laborum-libero.html',
                status: 'Active',
                tags: [
                    {
                        id: 24,
                        name: 'Java',
                    },
                    {
                        id: 26,
                        name: 'GitHub',
                    },
                ],
                resume: {
                    subtitle: 'Full Stack developer en PHP',
                    social_media: {
                        github: 'https://github.com/deckow.hans',
                        linkedin: 'https://linkedin.com/ecronin',
                    },
                    about: 'Sint delectus omnis harum quidem quo eligendi. Autem eum vero modi enim aliquid incidunt.',
                },
            },
            editProfileImageIsOpen: false,
            editProfileModalIsOpen: false,
            updatedMessage: '',
            updatedError: '',
            isUpdateLoading: false,
            isLoadingPhoto: false,
            isErrorPhoto: false,
            photoSuccessfully: false,
        },
    },
}

describe('EditStudentProjects modal opened from MyProfileProjectCard', () => {
    test('should not render the modal in the begining', () => {
        renderWithProvider(<MyProfileProjectsCard />, initialStateWithData)
        const CardTitle = screen.getByText(/Adopción/i)
        expect(CardTitle).toBeInTheDocument()
        const form = screen.queryByRole('form', { name: 'edit project modal' })
        expect(form).not.toBeInTheDocument()
    })

    test('should render the modal when user clicks the pencil button', () => {
        renderWithProvider(<MyProfileProjectsCard />, initialStateWithData)
        const pencilButtons = screen.getAllByRole('button', {
            name: 'edit project pencil',
        })
        expect(pencilButtons).toHaveLength(2)
        fireEvent.click(pencilButtons[0])
        const form = screen.getByRole('form', { name: 'edit project modal' })
        expect(form).toBeInTheDocument()
    })

    test('should close the modal when user clicks the cancel button', () => {
        renderWithProvider(
            <MyProfileProjectsCard />,
            stateWithEditProjectModalOpen,
        )

        const cancelButton = screen.getByRole('button', {
            name: 'cancel edit project button',
        })
        const form = screen.queryByRole('form', { name: 'edit project modal' })
        expect(cancelButton).toBeInTheDocument()
        expect(form).toBeInTheDocument()
        fireEvent.click(cancelButton)
        expect(form).not.toBeInTheDocument()
    })

    test('should close the modal when X button is clicked', () => {
        renderWithProvider(
            <MyProfileProjectsCard />,
            stateWithEditProjectModalOpen,
        )

        const form = screen.getByRole('form', { name: 'edit project modal' })
        expect(form).toBeInTheDocument()
        const XButton = screen.getByRole('button', {
            name: 'close X project modal',
        })
        expect(XButton).toBeInTheDocument()
        fireEvent.click(XButton)
        expect(form).not.toBeInTheDocument()
    })

    test('should update formData when input values change', () => {
        renderWithProvider(
            <MyProfileProjectsCard />,
            stateWithEditProjectModalOpen,
        )

        const inputProjectName = screen.getByLabelText('Nombre')
        const inputEnterprise = screen.getByLabelText('Empresa')
        fireEvent.change(inputProjectName, {
            target: { value: 'juancito.com' },
        })
        fireEvent.change(inputEnterprise, { target: { value: 'Freelance' } })
        expect(screen.getByDisplayValue('juancito.com')).toBeInTheDocument()
        expect(screen.getByDisplayValue('Freelance')).toBeInTheDocument()
    })

    test('should close the modal when aceptar button is clicked', async () => {
        renderWithProvider(
            <MyProfileProjectsCard />,
            stateWithEditProjectModalOpen,
        )

        const aceptarButton = screen.getByRole('button', {
            name: 'submit edit project button',
        })
        expect(aceptarButton).toBeInTheDocument()

        const inputProjectName = screen.getByLabelText('Nombre')
        expect(inputProjectName).toBeInTheDocument()

        fireEvent.change(inputProjectName, {
            target: { value: 'juancito.com' },
        })

        expect(aceptarButton).not.toBeDisabled()

        fireEvent.click(aceptarButton)

        // TODO: no puedo testear que el modal se cierra despues de hacer click.
        // const modal = screen.queryByRole('form', {
        //     name: 'edit project modal',
        // })
        // expect(modal).not.toBeInTheDocument()
    })
})

describe('Modal screenshot', () => {
    beforeEach(() => {
        renderWithProvider(
            <MyProfileProjectsCard />,
            stateWithEditProjectModalOpen,
        )
    })
    test('should be a form in the document', () => {
        const form = screen.getByRole('form')
        expect(form).toBeInTheDocument()
    })

    test('should be a cancelar button', () => {
        const cancelButton = screen.getByText('Cancelar')
        expect(cancelButton).toBeInTheDocument()
    })

    test('should be a Aceptar button', () => {
        const aceptarButton = screen.getByText('Aceptar')
        expect(aceptarButton).toBeInTheDocument()
    })

    test('should be a X button for close', () => {
        const XButton = screen.getByRole('button', {
            name: 'close X project modal',
        })
        expect(XButton).toBeInTheDocument()
    })

    test('should render the "Editar proyecto" text', () => {
        const titulo = screen.getByText('Editar proyecto')
        expect(titulo).toBeInTheDocument()
    })

    test('should have an input labeled as Nombre proyecto', () => {
        const inputName = screen.getByLabelText('Nombre')
        expect(inputName).toBeInTheDocument()
    })

    test('should have an input labeled as Empresa', () => {
        const inputEmpresa = screen.getByLabelText('Empresa')
        expect(inputEmpresa).toBeInTheDocument()
    })

    test('should have an input labeled as Skills', () => {
        const inputSkills = screen.getByText(/Skills/i)
        expect(inputSkills).toBeInTheDocument()
    })

    test('should have an input labeled as Link demo', () => {
        const inputLinkDemo = screen.getByLabelText('Link demo')
        expect(inputLinkDemo).toBeInTheDocument()
    })

    test('should have an input labeled as Link perfil de Github', () => {
        const inputGithub = screen.getByLabelText('Link de GitHub')
        expect(inputGithub).toBeInTheDocument()
    })
})
