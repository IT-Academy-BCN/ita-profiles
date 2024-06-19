import { render, screen, waitFor } from '@testing-library/react'
import { describe, test, beforeAll, afterEach, afterAll, vi } from 'vitest'
import axios from 'axios'
import MockAdapter from 'axios-mock-adapter'
import TermsPopUp from '../../../components/login_&_register/TermsPopUp'
import { fetchTermsAndConditions } from '../../../api/FetchTermsAndConditions'

// Mock the fetchTermsAndConditions function
vi.mock('../../../api/FetchTermsAndConditions', () => ({
    fetchTermsAndConditions: vi.fn(),
}))

describe('TermsPopUp component', () => {
    let mock: MockAdapter

    beforeAll(() => {
        mock = new MockAdapter(axios)
        mock.onGet('http://localhost:8000/api/v1/terms-and-conditions').reply(
            200,
            {
                content: 'These are the terms and conditions.',
            },
        )
    })

    afterEach(() => {
        mock.reset()
    })

    afterAll(() => {
        mock.restore()
    })

    const handleTermsPopup = vi.fn()

    test('should show the "Términos y Condiciones" header', () => {
        render(<TermsPopUp handleTermsPopup={handleTermsPopup} />)
        expect(screen.getByText('Términos y Condiciones')).toBeInTheDocument()
    })

    test('should fetch and display terms and conditions', async () => {
        // Mock the return value of the fetchTermsAndConditions function
        const mockFetchTerms = fetchTermsAndConditions as jest.Mock
        mockFetchTerms.mockResolvedValueOnce({
            content: 'These are the terms and conditions.',
        })

        render(<TermsPopUp handleTermsPopup={handleTermsPopup} />)

        const termsContent = await waitFor(() =>
            screen.getByText('These are the terms and conditions.'),
        )
        expect(termsContent).toBeInTheDocument()
    })

    test('should call handleTermsPopup when close button is clicked', () => {
        render(<TermsPopUp handleTermsPopup={handleTermsPopup} />)

        const closeButton = screen.getByRole('button', { name: '✕' })
        closeButton.click()

        expect(handleTermsPopup).toHaveBeenCalledTimes(1)
    })
})
