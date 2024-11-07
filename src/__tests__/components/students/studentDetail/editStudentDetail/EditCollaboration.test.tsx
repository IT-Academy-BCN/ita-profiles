/* import { Provider } from 'react-redux'
import { render, screen, fireEvent } from '@testing-library/react'
import { vi } from 'vitest'
import { EditCollaborations } from '../../../../../components/students/studentDetail/studentProfile/studentProfileCards/editStudentProfile/EditCollaborations'
import configureStore from 'redux-mock-store'
import thunk from 'redux-thunk'
import { updateCollaborationsThunk } from '../../../../../store/thunks/updateStudentProfileThunk'

// Initialize mock functions
const mockHandleModal = vi.fn()
const mockHandleRefresh = vi.fn()

// Mock store setup with thunk middleware
const mockStore = configureStore([thunk])
const initialState = {
    ShowStudentReducer: {
        studentDetails: { aboutData: { id: '1' } },
        studentCollaborations: {
            collaborationsData: [
                { quantity: 0 }, // for wikiCollaborations
                { quantity: 0 }, // for completedChallenges
            ],
        },
    },
}
const store = mockStore(initialState)

vi.mock('../../../../../store/thunks/updateStudentProfileThunk', () => ({
    updateCollaborationsThunk: vi.fn(),
}))

describe('EditCollaborations Component', () => {
    beforeEach(() => {
        vi.clearAllMocks()
        store.clearActions()
    })

    test('should update input values and submit the form', async () => {
        render(
            <Provider store={store}>
                <EditCollaborations handleModal={mockHandleModal} handleRefresh={mockHandleRefresh} />
            </Provider>
        )

        // Step 1: Update input fields
        const wikiInput = screen.getByLabelText('Número de recursos')
        const challengesInput = screen.getByLabelText('Número de retos')
        fireEvent.change(wikiInput, { target: { value: '5' } })
        fireEvent.change(challengesInput, { target: { value: '10' } })

        // Verify the input values were updated
        expect(wikiInput.value).toBe('5')
        expect(challengesInput.value).toBe('10')

        // Step 2: Submit the form
        const submitButton = screen.getByText('Aceptar')
        fireEvent.click(submitButton)

        // Verify the thunk was dispatched with correct data
        const expectedData = { collaborations: [5, 10] }
        expect(updateCollaborationsThunk).toHaveBeenCalledWith({
            url: 'http://localhost:8000/api/v1/student/1/resume/collaborations',
            formData: expectedData,
        })

        // Step 3: Simulate successful completion of thunk
        await updateCollaborationsThunk.mock.results[0].value

        // Verify handleRefresh and handleModal were called
        expect(mockHandleRefresh).toHaveBeenCalledWith('1')
        expect(mockHandleModal).toHaveBeenCalled()
    })
}) */

    import { Provider } from 'react-redux'
    import { render, screen, fireEvent, waitFor } from '@testing-library/react'
    import { vi } from 'vitest'
    import { EditCollaborations } from '../../../../../components/students/studentDetail/studentProfile/studentProfileCards/editStudentProfile/EditCollaborations'
    import configureStore from 'redux-mock-store'
    import thunk from 'redux-thunk'
    import { updateCollaborationsThunk } from '../../../../../store/thunks/updateStudentProfileThunk'
import userEvent from '@testing-library/user-event'
    
    // Mock functions for modal and refresh handling
    const mockHandleModal = vi.fn()
    const mockHandleRefresh = vi.fn()
    
    // Set up the Redux mock store with thunk middleware
    const mockStore = configureStore([thunk])
    const initialState = {
        ShowStudentReducer: {
            studentDetails: { aboutData: { id: '1' } },
            studentCollaborations: {
                collaborationsData: [
                    { quantity: 0 }, // wikiCollaborations initial value
                    { quantity: 0 }, // completedChallenges initial value
                ],
            },
        },
    }
    const store = mockStore(initialState)
    
    // Mocking the thunk itself
    vi.mock('../../../../../store/thunks/updateStudentProfileThunk', () => ({
        updateCollaborationsThunk: vi.fn().mockResolvedValue('success'), // mock success response
    }))
    
    describe('EditCollaborations Component', () => {
        beforeEach(() => {
            vi.clearAllMocks()
            store.clearActions()
        })
    
        test('should update input values and submit the form successfully', async () => {
            // Render component with mocked store and handlers
            render(
                <Provider store={store}>
                    <EditCollaborations handleModal={mockHandleModal} handleRefresh={mockHandleRefresh} />
                </Provider>
            )
    
            // Step 1: Update input fields
            const wikiInput = screen.getByText('Número de recursos')
            const challengesInput = screen.getByText('Número de retos')
            await userEvent.type(wikiInput, '5')
            await userEvent.type(challengesInput, '10')

    
            // Check that input values have been updated
            expect(wikiInput).toHaveValue('5')
            expect(challengesInput).toHaveValue('10')
    
            // Step 2: Submit the form
            const submitButton = screen.getByText('Aceptar')
            fireEvent.click(submitButton)
    
            // Step 3: Wait for async actions and verify dispatch with correct data
            await waitFor(() => {
                const expectedData = { collaborations: [5, 10] }
                expect(updateCollaborationsThunk).toHaveBeenCalledWith({
                    url: 'http://localhost:8000/api/v1/student/1/resume/collaborations',
                    formData: expectedData,
                })
            })
    
            // Step 4: Verify that handleRefresh and handleModal were called after thunk completion
            await waitFor(() => {
                expect(mockHandleRefresh).toHaveBeenCalledWith('1')
                expect(mockHandleModal).toHaveBeenCalled()
            })
        })
    })
    
