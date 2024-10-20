import { Provider } from 'react-redux'
import { fireEvent, render, screen } from '@testing-library/react'
import { expect } from 'vitest'
import { EditStudentProfile } from '../../../../../components/students/studentDetail/studentProfile/EditStudentProfile'
import { store } from '../../../../../store/store'

const mockHandleEditProfile = vi.fn()

const renderComponent = () => {
    return render(
        <Provider store={store}>
            <EditStudentProfile handleEditProfile={mockHandleEditProfile} />
        </Provider>,
    )
}

describe('EditStudentProfile Component', () => {
    test('should render the "Editar datos" text', () => {
        renderComponent()
        const title = screen.getByText('Editar datos')
        expect(title).toBeInTheDocument()
    })

    test('should be a form in the document', () => {
        renderComponent()
        const form = screen.getByRole('form')
        expect(form).toBeInTheDocument()
    })

    test('should be a cancel button', () => {
        renderComponent()
        const submitButton = screen.getByText('Aceptar')
        expect(submitButton).toBeInTheDocument()
    })

    test('should be a  Subir nueva imagen  button', () => {
        renderComponent()
        const uploadImage = screen.getByText('Subir nueva imagen')
        expect(uploadImage).toBeInTheDocument()
    })

    test('should render the "Editar datos" text', () => {
        renderComponent()
        const cancelButton = screen.getByText('Cancelar')
        expect(cancelButton).toBeInTheDocument()
    })

    test('should have an input labeled as Nombre y apellidos', () => {
        renderComponent()
        const inputFullName = screen.getByLabelText('Nombre y apellidos')
        expect(inputFullName).toBeInTheDocument()
    })

    test('should have an input labeled as Titular', () => {
        renderComponent()
        const inputTitular = screen.getByLabelText('Titular')
        expect(inputTitular).toBeInTheDocument()
    })

    test('should have an input labeled as Link perfil de Github', () => {
        renderComponent()
        const inputGithub = screen.getByLabelText('Link de perfil de Github')
        expect(inputGithub).toBeInTheDocument()
    })

    test('should have an input labeled as Link perfil de Linkedin', () => {
        renderComponent()
        const inputLinkedin = screen.getByLabelText('Link perfil de Linkedin')
        expect(inputLinkedin).toBeInTheDocument()
    })

    test('should have an input labeled as Descripción', () => {
        renderComponent()
        const inputDescription = screen.getByLabelText('Descripción')
        expect(inputDescription).toBeInTheDocument()
    })

    test('should have an profile image', () => {
        renderComponent()
        const profileImage = screen.getByAltText('Student profile')
        expect(profileImage).toBeInTheDocument()
    })

    test('should close the modal when cancel button is clicked', () => {
        renderComponent()
        const modal = screen.queryByRole('dialog')
        const cancelButton = screen.getByText('Cancelar')
        fireEvent.click(cancelButton)
        expect(modal).not.toBeInTheDocument()
    })

    test('should close the modal when X button is clicked', () => {
        renderComponent()
        const modal = screen.queryByRole('dialog')
        const XButton = screen.getByAltText('close icon')
        fireEvent.click(XButton)
        expect(modal).not.toBeInTheDocument()
    })
})

// test('should call handleSubmit on form submission', () => {
//     const consoleSpy = vi.spyOn(console, 'log')
//     renderComponent()
//     const inputFullName = screen.getByLabelText('Nombre y apellidos')
//     fireEvent.change(inputFullName, { target: { value: 'Juan Pérez' } })

//     const form = screen.getByRole('form')
//     fireEvent.submit(form)

//     expect(consoleSpy).toHaveBeenCalledWith({
//         fullName: 'Juan Pérez',
//         titular: '',
//         github: '',
//         linkedin: '',
//         description: '',
//     })

//     consoleSpy.mockRestore()
// })

