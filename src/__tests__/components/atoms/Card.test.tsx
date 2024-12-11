import { Card } from '../../../components/atoms/Card'
import { render, screen } from '../../test-utils'

const handleClick = vi.fn()

describe('Card', () => {
  test('renders card', () => {
    render(
      <Card>Card content</Card>
    )
    const card = screen.getByText('Card content')
    expect(card).toBeInTheDocument()
    expect(card).toHaveClass('bg-white px-4 py-2 rounded')
  })

  test('can click the card', () => {    
    render(
      <Card onClick={handleClick}>
        Click card
      </Card>
    )
    const card = screen.getByText('Click card')
    card.click()
    expect(handleClick).toHaveBeenCalledTimes(1)
  })
})
