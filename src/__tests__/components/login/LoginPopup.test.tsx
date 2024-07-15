import { BrowserRouter } from 'react-router-dom'
import { render, screen, fireEvent, waitFor } from '@testing-library/react'
import { describe, test, expect, beforeEach, beforeAll, afterEach, afterAll, vi } from 'vitest'
import axios from 'axios'
import MockAdapter from 'axios-mock-adapter'
import LoginPopup from '../../../components/login_&_register/LoginPopup'
import { LoginContext } from '../../../context/LoginContext'

// Mock the navigate function from react-router-dom
const mockNavigate = vi.fn()
vi.mock('react-router-dom', () => ({
  ...vi.importActual('react-router-dom'),
  useNavigate: () => mockNavigate,
}))

// Mock functions for the context
const mockLogin = vi.fn()
const mockLogout = vi.fn()
const mockIsLoggedIn = vi.fn()

// Create the mock context value
const mockContextValue = {
  login: mockLogin,
  logout: mockLogout,
  token2: 'mockToken',
  isLoggedIn: mockIsLoggedIn,
}

describe('LoginPopup', () => {
  const mockOnClose = vi.fn()
  const mockOnOpenRegisterPopup = vi.fn()
  let mockAxios: MockAdapter

  const props = {
    onClose: mockOnClose,
    onOpenRegisterPopup: mockOnOpenRegisterPopup,
    user: { id: '', token: '' },
  }

  beforeAll(() => {
    mockAxios = new MockAdapter(axios)
  })

  afterEach(() => {
    mockAxios.reset()
  })

  afterAll(() => {
    mockAxios.restore()
  })

  beforeEach(() => {
    render(
      <LoginContext.Provider value={mockContextValue}>
        <BrowserRouter>
          <LoginPopup {...props} />
        </BrowserRouter>
      </LoginContext.Provider>
    )
  })

  test('renders correctly', () => {
    expect(screen.getByText('Login')).toBeInTheDocument()
  })

  test('closes the popup when the close button is clicked', () => {
    fireEvent.click(screen.getByText('✕'))
    expect(mockOnClose).toHaveBeenCalled()
  })

  test('calls login and navigates on successful form submission', async () => {
    mockAxios.onPost('//localhost:8000/api/v1/signin').reply(200, {
      id: 'user1',
      token: 'token123',
    })

    fireEvent.input(screen.getByPlaceholderText('DNI o NIE'), {
      target: { value: 'dni123' },
    })
    fireEvent.input(screen.getByPlaceholderText('Contraseña'), {
      target: { value: 'password123' },
    })

    fireEvent.click(screen.getByText('Login'))

    await waitFor(() => {
      expect(mockLogin).toHaveBeenCalledWith({ id: 'user1', token: 'token123' })
    })
    expect(mockOnClose).toHaveBeenCalled()
    expect(mockNavigate).toHaveBeenCalledWith('/profile')
  })

  test('shows error message on failed form submission', async () => {
    mockAxios.onPost('//localhost:8000/api/v1/signin').reply(400)

    fireEvent.input(screen.getByPlaceholderText('DNI o NIE'), {
      target: { value: 'dni123' },
    })
    fireEvent.input(screen.getByPlaceholderText('Contraseña'), {
      target: { value: 'password123' },
    })

    fireEvent.click(screen.getByText('Login'))

    await waitFor(() => {
      expect(console.log).toHaveBeenCalledWith('error =>', expect.anything())
    })
  })
})
