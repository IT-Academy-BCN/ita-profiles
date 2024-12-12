import { Card } from '../../../components/atoms/Card'
import { fireEvent, render, screen } from '../../test-utils'

describe('Card', () => {
  test('renders card', () => {
    render(
      <Card>Card content</Card>
    )
    const card = screen.getByText('Card content')
    expect(card).toBeInTheDocument()
  })

  test('can click the card', () => {
    const handleClick = vi.fn()
    render(
      <Card onClick={handleClick}>
        Click card
      </Card>
    )
    const card = screen.getByText('Click card')
    card.click()
    expect(handleClick).toHaveBeenCalledTimes(1)
  })

  test('can interact with the card by pressing Enter', () => {
    const handleKeyDown = vi.fn()
    render(
      <Card onKeyDown={handleKeyDown}>
        Press Enter
      </Card>
    )
    const card = screen.getByText('Press Enter')
    fireEvent.keyDown(card, { key: "Enter" })
    expect(handleKeyDown).toHaveBeenCalledTimes(1)
  })
})
