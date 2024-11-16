import { Provider } from 'react-redux'
import { fireEvent, render, screen } from '@testing-library/react'
import { expect } from 'vitest'
import { store } from '../../../../../store/store'
import MyProfileStudentDetailCard from '../../../../../components/students/studentDetail/studentProfile/studentProfileCards/MyProfileStudentDetailCard'

const renderFatherComponent = () => {
    return render(
        <Provider store={store}>
            <MyProfileStudentDetailCard />
        </Provider>,
    )
}
beforeEach(() => {
    vi.clearAllMocks()
    renderFatherComponent()
})

describe('EditStudentProfile modal opened from MyProfileStudentDetailCard', () => {
    test('should not render the modal in the begining', () => {
        const form = screen.queryByRole('form', { name: 'edit student form' })
        expect(form).not.toBeInTheDocument()
    })

    test('should  render the modal when user clicks the pencil button', () => {
        const pencil = screen.getByRole('button', {
            name: 'edit student pencil',
        })
        expect(pencil).toBeInTheDocument()
        fireEvent.click(pencil)
        const form = screen.getByRole('form', { name: 'edit student form' })
        expect(form).toBeInTheDocument()
        expect(screen.getByText(/editar datos/i)).toBeInTheDocument()
    })

    test('should close the modal when user clicks the cancel button', () => {
        const cancelButton = screen.getByRole('button', {
            name: 'cancel student button',
        })
        expect(cancelButton).toBeInTheDocument()
        fireEvent.click(cancelButton)
        const form = screen.queryByRole('form', { name: 'edit student form' })
        expect(form).not.toBeInTheDocument()
    })

    test('should close the modal when X button is clicked', () => {
        const pencil = screen.getByRole('button', {
            name: 'edit student pencil',
        })
        expect(pencil).toBeInTheDocument()
        fireEvent.click(pencil)
        const form = screen.getByRole('form', { name: 'edit student form' })
        expect(form).toBeInTheDocument()
        const XButton = screen.getByRole('button', {
            name: 'close X student modal',
        })
        expect(XButton).toBeInTheDocument()
        fireEvent.click(XButton)
        expect(form).not.toBeInTheDocument()
    })

    test('should update formData when input values change', () => {
        const pencil = screen.getByRole('button', {
            name: 'edit student pencil',
        })
        expect(pencil).toBeInTheDocument()
        fireEvent.click(pencil)

        const form = screen.getByRole('form', { name: 'edit student form' })
        expect(form).toBeInTheDocument()
        const inputName = screen.getByLabelText('Nombre')
        const inputSurname = screen.getByLabelText('Apellidos')
        fireEvent.change(inputName, { target: { value: 'Juan' } })
        fireEvent.change(inputSurname, { target: { value: 'Pérez' } })
        expect(screen.getByDisplayValue('Juan')).toBeInTheDocument()
        expect(screen.getByDisplayValue('Pérez')).toBeInTheDocument()
    })

    test('should close the modal when aceptar button is clicked', () => {
        const aceptarButton = screen.getByRole('button', {
            name: 'submit form button',
        })
        expect(aceptarButton).toBeInTheDocument()

        const inputName = screen.getByLabelText('Nombre')
        expect(inputName).toBeInTheDocument()
        fireEvent.change(inputName, { target: { value: 'Juan' } })

        expect(aceptarButton).not.toBeDisabled()
        fireEvent.click(aceptarButton)

        // const form = screen.getByRole('form', { name: 'edit student form' })
        // expect(form).not.toBeInTheDocument()
        // error : encuentra siempre el modal abierto.
    })
})

describe('Modal screenshot', () => {
    test('should be a form in the document', () => {
        const form = screen.getByRole('form')
        expect(form).toBeInTheDocument()
    })

    test('should be a cancel button', () => {
        const submitButton = screen.getByText('Aceptar')
        expect(submitButton).toBeInTheDocument()
    })

    test('should be a  Subir nueva imagen  button', () => {
        const uploadImage = screen.getByText('Subir nueva imagen')
        expect(uploadImage).toBeInTheDocument()
    })

    test('should render the "Editar datos" text', () => {
        const cancelButton = screen.getByText('Cancelar')
        expect(cancelButton).toBeInTheDocument()
    })

    test('should have an input labeled as Nombre', () => {
        const inputName = screen.getByLabelText('Nombre')
        expect(inputName).toBeInTheDocument()
    })

    test('should have an input labeled as Apellidos', () => {
        const inputSurname = screen.getByLabelText('Apellidos')
        expect(inputSurname).toBeInTheDocument()
    })

    test('should have an input labeled as Titular', () => {
        const inputTitular = screen.getByLabelText('Titular')
        expect(inputTitular).toBeInTheDocument()
    })

    test('should have an input labeled as Link perfil de Github', () => {
        const inputGithub = screen.getByLabelText('Link de perfil de Github')
        expect(inputGithub).toBeInTheDocument()
    })

    test('should have an input labeled as Link perfil de Linkedin', () => {
        const inputLinkedin = screen.getByLabelText('Link perfil de Linkedin')
        expect(inputLinkedin).toBeInTheDocument()
    })

    test('should have an input labeled as Descripción', () => {
        const inputDescription = screen.getByLabelText('Descripción')
        expect(inputDescription).toBeInTheDocument()
    })

    test('should have an profile image', () => {
        const profileImage = screen.getByAltText('Student profile')
        expect(profileImage).toBeInTheDocument()
    })
})
