import { screen } from '@testing-library/react'
import { Provider } from 'react-redux' // Import Provider from react-redux
import { render } from '../../test-utils'
import Landing from '../../../components/landing/Landing'
import { store } from '../../../store/store'

describe('StudentDetailsLayout', () => {
  it('should render the studentDetailsLayout component correctly', () => {
    const { container } = render(
      <Provider store={store}>
        <Landing />
      </Provider>,
    )
    expect(container).toBeInTheDocument()
  })

  test('renders all the different cards', () => {
    expect(screen.queryByTestId('MenuNavbar')).toBeDefined()
    expect(screen.queryByTestId('UserNavbar')).toBeDefined()
    expect(screen.queryByTestId('StudentFiltersLayout')).toBeDefined()
    expect(screen.queryByTestId('StudentLayout')).toBeDefined()
    expect(screen.queryByTestId('StudentDetailsLayout')).toBeDefined()
  })
})
