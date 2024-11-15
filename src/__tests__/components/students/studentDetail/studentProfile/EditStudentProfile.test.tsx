import { Provider } from 'react-redux'
import { fireEvent, render, screen } from '@testing-library/react'
import { expect } from 'vitest'
import { EditStudentProfile } from '../../../../../components/students/studentDetail/studentProfile/studentProfileCards/editStudentProfile/EditStudentProfile'
import { store } from '../../../../../store/store'
import MyProfileStudentDetailCard from '../../../../../components/students/studentDetail/studentProfile/studentProfileCards/MyProfileStudentDetailCard'

const mockHandleRefresh = vi.fn()
const renderComponent = () => {
    return render(
        <Provider store={store}>
            <MyProfileStudentDetailCard />
            <EditStudentProfile
                handleRefresh={mockHandleRefresh}
            />
        </Provider>,
    )
}

beforeEach(() => {
    vi.clearAllMocks()
})

describe('EditStudentProfile Component', () => {
    test('should not render the modal', () => {
        renderComponent()
        const modal = screen.queryByRole('dialog', {
            name: 'edit student modal',
        })
        expect(modal).not.toBeInTheDocument()
    })

    test('should open the modal when user clicks on pencil button', () => {
        renderComponent()
        const pencilButton = screen.getByRole('button', {
            name: 'open edit profile modal',
        })
        expect(pencilButton).toBeInTheDocument()
        fireEvent.click(pencilButton)

        const modal = screen.getByRole('form', {
            name: 'edit student modal',
        })

        expect(modal).toBeInTheDocument()
    })

    // test('should render the "Editar datos" text', () => {
    //     renderComponent()
    //     const title = screen.getByText('Editar datos')
    //     expect(title).toBeInTheDocument()
    // })

    // test('should be a form in the document', () => {
    //     renderComponent()
    //     const form = screen.getByRole('form')
    //     expect(form).toBeInTheDocument()
    // })

    // test('should be a cancel button', () => {
    //     renderComponent()
    //     const submitButton = screen.getByText('Aceptar')
    //     expect(submitButton).toBeInTheDocument()
    // })

    // test('should be a  Subir nueva imagen  button', () => {
    //     renderComponent()
    //     const uploadImage = screen.getByText('Subir nueva imagen')
    //     expect(uploadImage).toBeInTheDocument()
    // })

    // test('should render the "Editar datos" text', () => {
    //     renderComponent()
    //     const cancelButton = screen.getByText('Cancelar')
    //     expect(cancelButton).toBeInTheDocument()
    // })

    // test('should have an input labeled as Nombre y apellidos', () => {
    //     renderComponent()
    //     const inputName = screen.getByLabelText('Nombre')
    //     expect(inputName).toBeInTheDocument()
    // })

    // test('should have an input labeled as Apellidos', () => {
    //     renderComponent()
    //     const inputSurname = screen.getByLabelText('Apellidos')
    //     expect(inputSurname).toBeInTheDocument()
    // })

    // test('should have an input labeled as Titular', () => {
    //     renderComponent()
    //     const inputTitular = screen.getByLabelText('Titular')
    //     expect(inputTitular).toBeInTheDocument()
    // })

    // test('should have an input labeled as Link perfil de Github', () => {
    //     renderComponent()
    //     const inputGithub = screen.getByLabelText('Link de perfil de Github')
    //     expect(inputGithub).toBeInTheDocument()
    // })

    // test('should have an input labeled as Link perfil de Linkedin', () => {
    //     renderComponent()
    //     const inputLinkedin = screen.getByLabelText('Link perfil de Linkedin')
    //     expect(inputLinkedin).toBeInTheDocument()
    // })

    // test('should have an input labeled as Descripción', () => {
    //     renderComponent()
    //     const inputDescription = screen.getByLabelText('Descripción')
    //     expect(inputDescription).toBeInTheDocument()
    // })

    // test('should have an profile image', () => {
    //     renderComponent()
    //     const profileImage = screen.getByAltText('Student profile')
    //     expect(profileImage).toBeInTheDocument()
    // })
})

// describe('EditStudentProfile component interaccion test', () => {
//     test('should close the modal when cancel button is clicked', () => {
//         renderComponent()
//         const modal = screen.queryByRole('dialog')
//         const cancelButton = screen.getByText('Cancelar')
//         fireEvent.click(cancelButton)
//         expect(modal).not.toBeInTheDocument()
//     })

//     test('should close the modal when X button is clicked', () => {
//         renderComponent()
//         const modal = screen.queryByRole('dialog')
//         const XButton = screen.getByAltText('close icon')
//         fireEvent.click(XButton)
//         expect(modal).not.toBeInTheDocument()
//     })

//     test('should close the modal when aceptar button is clicked', () => {
//         renderComponent()
//         const modal = screen.queryByRole('dialog')
//         const aceptarButton = screen.getByText('Aceptar')
//         fireEvent.click(aceptarButton)
//         expect(modal).not.toBeInTheDocument()
//     })

//     test('should update formData when input values change', () => {
//         renderComponent()
//         const inputName = screen.getByLabelText('Nombre')
//         const inputSurname = screen.getByLabelText('Apellidos')
//         fireEvent.change(inputName, { target: { value: 'Juan' } })
//         fireEvent.change(inputSurname, { target: { value: 'Pérez' } })
//         expect(screen.getByDisplayValue('Juan')).toBeInTheDocument()
//         expect(screen.getByDisplayValue('Pérez')).toBeInTheDocument()
//     })
// })
