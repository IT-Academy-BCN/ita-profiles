import { Provider } from 'react-redux'
import { render, screen } from '@testing-library/react'
import { expect } from 'vitest'
import { store } from '../../../../../store/store'
import MyProfileProjectsCard from '../../../../../components/students/studentDetail/studentProfile/studentProfileCards/MyProfileProjectsCard'

const renderFatherComponent = () => {
    return render(
        <Provider store={store}>
            <MyProfileProjectsCard />
        </Provider>,
    )
}
beforeEach(() => {
    vi.clearAllMocks()
    renderFatherComponent()
})

describe('EditStudentProjects modal opened from MyProfileProjectCard', () => {

    test('should not render the modal in the begining', () => {
        const form = screen.queryByRole('form', { name: 'edit project form' })
        expect(form).not.toBeInTheDocument()
    })

    // test('should  render the modal when user clicks the pencil button', () => {
    //     const pencil = screen.getByRole('button', {
    //         name: 'edit project pencil',
    //     })
    //     expect(pencil).toBeInTheDocument()
    //     fireEvent.click(pencil)
    //     const form = screen.getByRole('form', { name: 'edit project form' })
    //     expect(form).toBeInTheDocument()
    //     expect(screen.getByText(/editar datos/i)).toBeInTheDocument()
    // })

    // test('should close the modal when user clicks the cancel button', () => {
    //     const cancelButton = screen.getByRole('button', {
    //         name: 'cancel project button',
    //     })
    //     expect(cancelButton).toBeInTheDocument()
    //     fireEvent.click(cancelButton)
    //     const form = screen.queryByRole('form', { name: 'edit project form' })
    //     expect(form).not.toBeInTheDocument()
    // })

    // test('should close the modal when X button is clicked', () => {
    //     const pencil = screen.getByRole('button', {
    //         name: 'edit project pencil',
    //     })
    //     expect(pencil).toBeInTheDocument()
    //     fireEvent.click(pencil)
    //     const form = screen.getByRole('form', { name: 'edit project form' })
    //     expect(form).toBeInTheDocument()
    //     const XButton = screen.getByRole('button', {
    //         name: 'close X project modal',
    //     })
    //     expect(XButton).toBeInTheDocument()
    //     fireEvent.click(XButton)
    //     expect(form).not.toBeInTheDocument()
    // })

    // test('should update formData when input values change', () => {
    //     const pencil = screen.getByRole('button', {
    //         name: 'edit project pencil',
    //     })
    //     expect(pencil).toBeInTheDocument()
    //     fireEvent.click(pencil)

    //     const form = screen.getByRole('form', { name: 'edit project form' })
    //     expect(form).toBeInTheDocument()
    //     const inputProjectName = screen.getByLabelText('Nombre proyecto')
    //     const inputEnterprise = screen.getByLabelText('Empresa')
    //     fireEvent.change(inputProjectName, {
    //         target: { value: 'juancito.com' },
    //     })
    //     fireEvent.change(inputEnterprise, { target: { value: 'Freelance' } })
    //     expect(screen.getByDisplayValue('juancito.com')).toBeInTheDocument()
    //     expect(screen.getByDisplayValue('Freelance')).toBeInTheDocument()
    // })

    // test('should close the modal when aceptar button is clicked', () => {
    //     const aceptarButton = screen.getByRole('button', {
    //         name: 'submit project form button',
    //     })
    //     expect(aceptarButton).toBeInTheDocument()

    //     const inputProjectName = screen.getByLabelText('Nombre proyecto')
    //     expect(inputProjectName).toBeInTheDocument()
    //     fireEvent.change(inputProjectName, {
    //         target: { value: 'juancito.com' },
    //     })

    //     expect(aceptarButton).not.toBeDisabled()
    //     fireEvent.click(aceptarButton)
    // })
})

// describe('Modal screenshot', () => {
//     test('should be a form in the document', () => {
//         const form = screen.getByRole('form')
//         expect(form).toBeInTheDocument()
//     })

//     test('should be a cancelar button', () => {
//         const cancelButton = screen.getByRole('button', {
//             name: 'cancel project button',
//         })
//         expect(cancelButton).toBeInTheDocument()
//     })

//     test('should be a Aceptar button', () => {
//         const aceptarButton = screen.getByRole('button', {
//             name: 'submit project form button',
//         })
//         expect(aceptarButton).toBeInTheDocument()
//     })

//     test('should be a X button for close', () => {
//         const XButton = screen.getByRole('button', {
//             name: 'close X project modal',
//         })
//         expect(XButton).toBeInTheDocument()
//     })

//     test('should render the "Editar proyecto" text', () => {
//         const titulo = screen.getByText('Editar proyecto')
//         expect(titulo).toBeInTheDocument()
//     })

//     test('should have an input labeled as Nombre proyecto', () => {
//         const inputName = screen.getByLabelText('Nombre proyecto')
//         expect(inputName).toBeInTheDocument()
//     })

//     test('should have an input labeled as Empresa', () => {
//         const inputEmpresa = screen.getByLabelText('Empresa')
//         expect(inputEmpresa).toBeInTheDocument()
//     })

//     test('should have an input labeled as Skills', () => {
//         const inputSkills = screen.getByLabelText('Skills')
//         expect(inputSkills).toBeInTheDocument()
//     })

//     test('should have an input labeled as Link demo', () => {
//         const inputLinkDemo = screen.getByLabelText('Link demo')
//         expect(inputLinkDemo).toBeInTheDocument()
//     })

//     test('should have an input labeled as Link perfil de Github', () => {
//         const inputGithub = screen.getByLabelText('Link perfil de Github')
//         expect(inputGithub).toBeInTheDocument()
//     })
// })
