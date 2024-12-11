import { render, screen, waitFor } from '@testing-library/react'
import { expect, vi, it, describe } from 'vitest'
import userEvent from '@testing-library/user-event'
import { Input } from '../../components/atoms/Input'

const onChangeMock = vi.fn()

describe('Input Component', () => {
    it('renders correctly and handles user input', async () => {
        render(
            <Input
                placeholder="Type here"
                id="test-input"
                onChange={onChangeMock}
            />,
        )

        const userInput = screen.getByPlaceholderText('Type here')
        expect(userInput).toBeInTheDocument()

        userEvent.type(userInput, 'test value')

        await waitFor(() => {
            expect(onChangeMock).toHaveBeenCalledTimes(10)
            expect(userInput).toHaveValue('test value')
        })
    })

    it('applies error styles when error is true', () => {
        render(<Input placeholder="Error state" error />)
        const userInput = screen.getByPlaceholderText(/error state/i)
        expect(userInput).toHaveClass('border-red-500')
        expect(userInput).toHaveAttribute('aria-invalid', 'true')
    })

    it('applies warning styles when warning is true', () => {
        render(<Input placeholder="Warning state" warning />)
        const userInput = screen.getByPlaceholderText(/warning state/i)
        expect(userInput).toHaveClass('border-yellow-500')
    })

    it('applies success styles when success is true', () => {
        render(<Input placeholder="Success state" success />)
        const userInput = screen.getByPlaceholderText(/success state/i)
        expect(userInput).toHaveClass('border-green-500')
    })

    it('applies default styles when no state props are passed', () => {
        render(<Input placeholder="Default state" />)
        const userInput = screen.getByPlaceholderText(/default state/i)
        expect(userInput).toHaveClass('border-gray-300')
    })

    it('handles aria-invalid for accessibility when error is a string', () => {
        render(<Input placeholder="Aria test" error="Invalid input" />)
        const userInput = screen.getByPlaceholderText(/aria test/i)
        expect(userInput).toHaveAttribute('aria-invalid', 'true')
    })

    it('supports different input types', () => {
        const { rerender } = render(
            <Input placeholder="Text input" type="text" />,
        )
        const textInput = screen.getByPlaceholderText('Text input')
        expect(textInput).toHaveAttribute('type', 'text')

        rerender(<Input placeholder="Password input" type="password" />)
        const passwordInput = screen.getByPlaceholderText('Password input')
        expect(passwordInput).toHaveAttribute('type', 'password')

        rerender(<Input placeholder="Email input" type="email" />)
        const emailInput = screen.getByPlaceholderText('Email input')
        expect(emailInput).toHaveAttribute('type', 'email')
    })
})
