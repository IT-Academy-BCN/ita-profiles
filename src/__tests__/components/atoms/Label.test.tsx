import { render, screen } from '@testing-library/react'
import Label from '../../../components/atoms/Label'

describe('Label component', () => {
  it('renders correctly with text and htmlFor', () => {
    render(<Label text="Test Label" htmlFor="test-input" />)
    const label = screen.getByText('Test Label')
    expect(label).toBeInTheDocument()
    expect(label).toHaveAttribute('for', 'test-input')
  })

  it('applies hidden styles when hiddenLabel is true', () => {
    render(<Label text="Hidden Label" htmlFor="test-input" hiddenLabel />)
    const label = screen.getByText('Hidden Label')
    expect(label).toHaveClass('sr-only')
  })

  it('does not apply hidden styles when hiddenLabel is false', () => {
    render(<Label text="Visible Label" htmlFor="test-input" hiddenLabel={false} />)
    const label = screen.getByText('Visible Label')
    expect(label).not.toHaveClass('sr-only')
  })

  it('renders with additional attributes passed via rest', () => {
    render(
      <Label
        text="Test Label"
        htmlFor="test-input"
        hiddenLabel={false}
        data-testid="custom-label"
      />
    )
    const label = screen.getByTestId('custom-label')
    expect(label).toBeInTheDocument()
  })

  it('renders correctly when text is an empty string', () => {
    render(<Label htmlFor="test-input" text="" data-testid="custom-label"/>)
    const label = screen.getByTestId('custom-label')
    expect(label).toBeInTheDocument()
    expect(label).toHaveTextContent('')
  })
})
