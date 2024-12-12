import { Card } from '../../../components/atoms/Card'
import { render, screen } from '../../test-utils'

describe('Card', () => {
  test('renders card', () => {
    render(
      <Card>Card content</Card>
    )
    const card = screen.getByText('Card content')
    expect(card).toBeInTheDocument()
  })
})
