import { Provider } from 'react-redux'
import { fireEvent, render, screen, waitFor } from '@testing-library/react'
import { expect } from 'vitest'
import { EditStudentProfile } from '../../../../../components/students/studentDetail/studentProfile/studentProfileCards/editStudentProfile/EditStudentProfile'
import { store } from '../../../../../store/store'

const mockHandleModal = vi.fn()
const mockHandleRefresh = vi.fn()

const renderComponent = () => {
    return render(
        <Provider store={store}>
            <EditStudentProfile
                handleModal={mockHandleModal}
                handleRefresh={mockHandleRefresh}
            />
        </Provider>,
    )
}

beforeEach(() => {
    vi.clearAllMocks()
    renderComponent()
})

describe('EditStudentProfile Component', () => {
    test('should render the "Editar datos" text', () => {
        const title = screen.getByText('Editar datos')
        expect(title).toBeInTheDocument()
    })

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

describe('EditStudentProfile component interaccion test', () => {
    test('should close the modal when cancel button is clicked', async () => {
        const cancelButton = screen.getByText('Cancelar')
        fireEvent.click(cancelButton)
        await waitFor(() => {
            expect(screen.queryByRole('dialog')).not.toBeInTheDocument()
        })
    })

    // test('should close the modal when X button is clicked', () => {
    //     renderComponent()
    //     const modal = screen.queryByRole('dialog')
    //     const XButton = screen.getByAltText('close icon')
    //     fireEvent.click(XButton)
    //     expect(modal).not.toBeInTheDocument()
    // })

    // test('should close the modal when aceptar button is clicked', () => {
    //     renderComponent()
    //     const modal = screen.queryByRole('dialog')
    //     const aceptarButton = screen.getByText('Aceptar')
    //     fireEvent.click(aceptarButton)
    //     expect(modal).not.toBeInTheDocument()
    // })

    test('should update formData when input values change', () => {
        const inputName = screen.getByLabelText('Nombre')
        const inputSurname = screen.getByLabelText('Apellidos')
        fireEvent.change(inputName, { target: { value: 'Juan' } })
        fireEvent.change(inputSurname, { target: { value: 'Pérez' } })
        expect(screen.getByDisplayValue('Juan')).toBeInTheDocument()
        expect(screen.getByDisplayValue('Pérez')).toBeInTheDocument()
    })
})
