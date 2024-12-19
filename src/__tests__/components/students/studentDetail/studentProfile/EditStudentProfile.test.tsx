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

    test('should update formData when input values change', () => {
        const pencil = screen.getByAltText('edit profile information')
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
    })
})