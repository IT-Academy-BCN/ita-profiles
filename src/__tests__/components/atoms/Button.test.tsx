import { render, screen } from '../../test-utils'
import { Button } from '../../../components/atoms/Button'

describe('Button', () => {
  test('renders button', () => {
    render(<Button>Hello World</Button>)
    const button = screen.getByText('Hello World')
    expect(button).toBeInTheDocument()
    expect(button).toHaveAttribute('type', 'button')
  })

  test('can click the button', () => {
    const handleClick = vi.fn()
    render(<Button onClick={handleClick}>Click Me</Button>)
    const button = screen.getByText('Click Me')
    button.click()
    expect(handleClick).toHaveBeenCalledTimes(1)
  })
})
