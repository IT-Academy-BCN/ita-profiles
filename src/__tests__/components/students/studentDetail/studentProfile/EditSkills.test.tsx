import { Provider } from 'react-redux'
import { fireEvent, render, screen, waitFor } from '@testing-library/react'
import { expect } from 'vitest'
import { store } from '../../../../../store/store'
import EditSkills from '../../../../../components/students/studentDetail/studentProfile/studentProfileCards/editStudentProfile/EditSkills'

const mockOnSave = vi.fn()
const mockOnClose = vi.fn()

const renderComponent = (initialSkills = []) => {
    return render(
        <Provider store={store}>
            <EditSkills
                initialSkills={initialSkills}
                onSave={mockOnSave}
                onClose={mockOnClose}
            />
        </Provider>,
    )
}

beforeEach(() => {
    vi.clearAllMocks()
})

describe('EditSkills Component', () => {
    test('renders the "Editar skills" header', () => {
        renderComponent()
        const header = screen.getByText('Editar skills')
        expect(header).toBeInTheDocument()
    })

    test('renders an input for adding new skills', () => {
        renderComponent()
        const skillInput = screen.getByPlaceholderText('Nuevo skill')
        expect(skillInput).toBeInTheDocument()
    })

    test('should be a cancel button', () => {
        renderComponent()
        const submitButton = screen.getByText('Aceptar')
        expect(submitButton).toBeInTheDocument()
    })

    test('adds a new skill when "+" button is clicked', () => {
        renderComponent()
        const skillInput = screen.getByPlaceholderText('Nuevo skill')
        fireEvent.change(skillInput, { target: { value: 'React' } })
        fireEvent.click(screen.getByText('+'))

        expect(screen.getByText('React')).toBeInTheDocument()
    })

    test('calls onClose when "Cancelar" button is clicked', () => {
        renderComponent()
        const cancelButton = screen.getByText('Cancelar')
        fireEvent.click(cancelButton)
        expect(mockOnClose).toHaveBeenCalled()
    })

    test('should update skills when a new skill is added', async () => {
        renderComponent()
        const input = screen.getByPlaceholderText('Nuevo skill')
        expect(input).toBeInTheDocument()
        fireEvent.change(input, { target: { value: 'Vue' } })
        const addButton = screen.getByText('+')
        fireEvent.click(addButton)
        await waitFor(() => screen.getByText('Vue'))
        expect(screen.getByText('Vue')).toBeInTheDocument()
    })
})
