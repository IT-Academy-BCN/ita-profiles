import { render, screen } from '@testing-library/react'
import userEvent from '@testing-library/user-event'
import { expect, describe, it, vi } from 'vitest'
import InputGroup from '../../../components/molecules/InputGroup'

describe('InputGroup Component', () => {
    it('renders the InputGroup with label and input', () => {
        render(
            <InputGroup
                id="name"
                label="name"
                placeholder="write name"
                type="text"
            />,
        )

        const labelElement = screen.getByText('name')
        const inputElement = screen.getByPlaceholderText('write name')

        expect(labelElement).toBeInTheDocument()
        expect(labelElement).toHaveAttribute('for', 'name')
        expect(inputElement).toBeInTheDocument()
        expect(inputElement).toHaveAttribute('id', 'name')
        expect(inputElement).toHaveAttribute('type', 'text')
    })

    it('hides the label when hiddenLabel is true', () => {
        render(
            <InputGroup
                id="hiddenLabel"
                label="Hidden Label"
                hiddenLabel
                placeholder="Type here"
                type="password"
            />,
        )

        const labelElement = screen.getByText('Hidden Label')
        const inputElement = screen.getByPlaceholderText('Type here')

        expect(labelElement).toBeInTheDocument()
        expect(labelElement).toHaveClass('sr-only')

        expect(inputElement).toBeInTheDocument()
        expect(inputElement).toHaveAttribute('type', 'password')
    })

    it('Input Group with label, input, and displays message error', () => {
        const { container } = render(
            <InputGroup
                id="test-email-input"
                label="email"
                type="email"
                errorMessage="the email is not correct"
            />,
        )

        const inputElement = container.querySelector('input')
        const labelElement = screen.getByText('email')
        const validationMessage = container.querySelector('span')

        expect(inputElement).toBeInTheDocument()
        expect(inputElement).toHaveAttribute('type', 'email')

        expect(labelElement).toBeInTheDocument()

        expect(validationMessage).toBeInTheDocument()
        expect(validationMessage).toHaveClass('text-red-500')
        expect(validationMessage?.textContent).toBe('the email is not correct')
    })

    it('Input Group without label, with input and displaying correct validation message for success', () => {
        const { container } = render(
            <InputGroup
                id="test-input-group"
                successMessage="Success message"
            />,
        )

        const inputElement = container.querySelector('#test-input-group')
        const validationMessage = container.querySelector('span')

        expect(inputElement).toBeInTheDocument()
        expect(inputElement).toHaveAttribute('type', 'text')

        expect(validationMessage).toBeInTheDocument()
        expect(validationMessage).toHaveClass('text-green-500')
        expect(validationMessage).toHaveTextContent('Success message')

        const label = container.querySelector('label')
        expect(label).toBeNull()
    })

    it('displays the correct validation message for warning', () => {
        render(
            <InputGroup
                id="test-input-group"
                label="Test Label"
                warningMessage="Warning message"
            />,
        )

        const validationMessage = screen.getByText('Warning message')
        expect(validationMessage).toBeInTheDocument()
        expect(validationMessage).toHaveClass('text-yellow-500')
    })
})
