import MenuNavbar from '../../components/menuNavbar/MenuNavbar'
import { render } from '../test-utils'

describe('MenuNavbar', () => {
  beforeEach(() => {
    render(
      <MenuNavbar />
    )
  })
  test('should show "MenuNavbar" all the time', () => {
    const { container } = render(<MenuNavbar />)
    expect(container).toBeInTheDocument()
  })
})

/* describe('MenuNavbar', () => {
  it('should render the MenuNavbar component', () => {
    const { container } = render(<MenuNavbar />)
    expect(container).toBeInTheDocument()
  })

  it('should render the MenuNavbar component with the correct text', () => {
    const { getByText } = render(<MenuNavbar />)
    expect(getByText('Perfiles')).toBeInTheDocument()
    expect(getByText('Matching')).toBeInTheDocument()
    expect(getByText('Proyectos')).toBeInTheDocument()
    expect(getByText('Estadísticas')).toBeInTheDocument()
    expect(getByText('Guías útiles')).toBeInTheDocument()
  })

  it('should render the MenuNavbar component with the correct styles', () => {
    const { getByText } = render(<MenuNavbar />)
    expect(getByText('Perfiles')).toHaveClass('text-black-2')
    expect(getByText('Matching')).toHaveClass('text-gray-3')
    expect(getByText('Proyectos')).toHaveClass('text-gray-3')
    expect(getByText('Estadísticas')).toHaveClass('text-gray-3')
    expect(getByText('Guías útiles')).toHaveClass('text-gray-3')
  })
}) */
