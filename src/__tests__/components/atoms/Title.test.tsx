import { render, screen } from '@testing-library/react'
import Title from '../../../components/atoms/Title'

describe('Title', () => {
    it('should render the title', () => {
        render(
            <Title as="h2" className="text-2xl">
                test
            </Title>,
        )
        const titleElement = screen.getByText('test')

        expect(titleElement).toBeInTheDocument()
        expect(titleElement.tagName).not.toBe('H1')
        expect(titleElement.tagName).toBe('H2')
        expect(titleElement).toHaveClass('text-2xl')
    })
})
