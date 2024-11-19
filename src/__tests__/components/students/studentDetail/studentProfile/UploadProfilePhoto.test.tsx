import { Provider } from 'react-redux'
import { describe, expect } from 'vitest'
import { fireEvent, render, screen } from '@testing-library/react'
import { store } from '../../../../../store/store'
import UploadProfilePhoto from '../../../../../components/students/studentDetail/studentProfile/studentProfileCards/editStudentProfile/UploadProfilePhoto'
import MyProfileStudentDetailCard from '../../../../../components/students/studentDetail/studentProfile/studentProfileCards/MyProfileStudentDetailCard'

const renderComponent = () => {
    return render(
        <Provider store={store}>
            <MyProfileStudentDetailCard />
        </Provider>,
    )
}

describe('UploadProfilePhoto Component', () => {
    beforeEach(() => {
        renderComponent()
    })

    it('should be defined', () => {
        expect(UploadProfilePhoto).toBeDefined()
    })

    it('At first, the modal should not be visible', () => {
        const form = screen.queryByRole('button', {
            name: 'Cerrar modal imagen',
        })
        expect(form).not.toBeInTheDocument()
    })

    it('should render modal when user clicks the upload image button', () => {
        const pencil = screen.getByRole('button', {
            name: 'edit student pencil',
        })
        expect(pencil).toBeInTheDocument()
        fireEvent.click(pencil)

        const openButton = screen.getByRole('button', {
            name: 'Open upload image modal',
        })
        expect(openButton).toBeInTheDocument()
        fireEvent.click(openButton)

        const form = screen.getByRole('button', {
            name: 'Cerrar modal imagen',
        })
        expect(form).toBeInTheDocument()
    })

    it('should close modal when user clicks the X button', () => {
        const cerrarButton = screen.getByRole('button', {
            name: 'Cerrar modal imagen',
        })
        expect(cerrarButton).toBeInTheDocument()
        fireEvent.click(cerrarButton)
        expect(cerrarButton).not.toBeInTheDocument()
    })

    it('should close modal when user clicks the cancel button', () => {
        const openButton = screen.getByRole('button', {
            name: 'Open upload image modal',
        })

        expect(openButton).toBeInTheDocument()
        fireEvent.click(openButton)

        const aceptarButton = screen.getByRole('button', {
            name: 'Aceptar photo',
        })

        expect(aceptarButton).toBeInTheDocument()
    })
})
