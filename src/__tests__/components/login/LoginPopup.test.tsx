import { BrowserRouter } from 'react-router-dom'
import { render, screen, fireEvent, waitFor } from '@testing-library/react'
import { describe, test, expect, beforeEach, beforeAll, afterEach, afterAll, vi } from 'vitest'
import axios from 'axios'
import MockAdapter from 'axios-mock-adapter'
import LoginPopup from '../../../components/login_&_register/LoginPopup'
import { LoginContext } from '../../../context/LoginContext'


// Source: https://gist.github.com/CarmeloRicarte/ee7b9908c0ef20eae32428de77a0cd4a
// But nothing is working...
// this is how to mock partial library for mock a method, in this case, useNavigate
const mockNavigate = vi.fn();
vi.mock("react-router-dom", async () => {
  const mod = await vi.importActual<typeof import("react-router-dom")>(
    "react-router-dom"
  );
  return {
    ...mod,
    useNavigate: () => mockNavigate,
  };
});



// Mock functions for the context
const mockLogin = vi.fn().mockImplementation(() => {});
const mockIsLoggedIn = vi.fn();
// Create the mock context value
const mockContextValue = {
  token: 'mockToken',
  login: mockLogin,
  logout:  mockIsLoggedIn,
  isLoggedIn: false,
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

  beforeEach(() => {
    render(
      <LoginContext.Provider value={mockContextValue}>
        <BrowserRouter>
          <LoginPopup {...props} />
        </BrowserRouter>
      </LoginContext.Provider>
    )
  })
  

  afterEach(() => {
    mockAxios.reset()
  })

  afterAll(() => {
    mockAxios.restore()
  })

  test('renders projects correctly', async () => {

    // Wait for projects to load
    const projectsElement = screen.getByText('Recordar/cambiar contraseña');
    const projectsLoginElement =  screen.getByRole('button', {
      name: /Login/i
    })
    
    // Check if projects are rendered correctly
    expect(projectsElement).toBeInTheDocument();
    expect(projectsLoginElement).toBeInTheDocument();
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
      target: { value: '48332312C' },
    })
    fireEvent.input(screen.getByPlaceholderText('Contraseña'), {
      target: { value: 'passOnePass' },
    })

    fireEvent.click(screen.getByRole('button', {
      name: /Login/i
    }))
    
    await waitFor(() => {
      // console.log('mockOnClose called:', mockOnClose.mock.calls.length);
      // console.log('mockNavigate times called:', mockNavigate.mock.calls.length);
      expect(mockOnClose).toHaveBeenCalled();
      // expect(mockLogin).toHaveBeenCalled();
      expect(mockLogin).toHaveBeenCalledWith({ id: 'user1', token: 'token123' })
      expect(mockNavigate).toHaveBeenCalledWith('/profile')
    });


  })

  test('shows error message on failed form submission', async () => {

    mockAxios.onPost('//localhost:8000/api/v1/signin').reply(401)

    fireEvent.input(screen.getByPlaceholderText('DNI o NIE'), {
      target: { value: '48332312C' },
    })
    fireEvent.input(screen.getByPlaceholderText('Contraseña'), {
      target: { value: 'password123' },
    })

    await fireEvent.click(screen.getByRole('button', {
      name: /Login/i
    }))

    await waitFor(() => {
      expect('error =>', expect.anything())
    })

    const projectsElement = screen.getByText('El usuario o la contraseña son incorrectos.');
    await waitFor(() => {
      expect(projectsElement).toBeInTheDocument();
    })
    // eslint-disable-next-line no-console
    console.log('In Order to launch the tests.');
  })
})
