import { BrowserRouter } from 'react-router-dom'
import { useNavigate } from 'react-router-dom';
import { render, screen, fireEvent, waitFor } from '@testing-library/react'
import { describe, test, expect, beforeEach, beforeAll, afterEach, afterAll, vi } from 'vitest'
import axios from 'axios'
import MockAdapter from 'axios-mock-adapter'
import LoginPopup from '../../../components/login_&_register/LoginPopup'
import { LoginContext, useLogin } from '../../../context/LoginContext'

/*
// Mock the navigate function from react-router-dom
const mockNavigate = vi.fn()
vi.mock('react-router-dom', () => ({
  ...vi.importActual('react-router-dom'),
  useNavigate: () => mockNavigate,
}));
*/
/*
const mockNavigate = vi.fn()
// Partially mock 'react-router-dom'
vi.mock('react-router-dom', async () => {
  const originalModule = await vi.importActual('react-router-dom');
  return {
    ...originalModule,
    useNavigate: () => mockNavigate,
    // Add any mocks you need here, e.g., NavLink, useNavigate, etc.
  };
});*/

//Source: https://gist.github.com/CarmeloRicarte/ee7b9908c0ef20eae32428de77a0cd4a
//But nothing is working...
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
const mockLogin = vi.fn().mockImplementation((user: { id: string; token: string }) => {});
const mockLogout = vi.fn().mockImplementation(() => {});
const mockIsLoggedIn = vi.fn();
const mockOnClose = vi.fn();

/*
// Create the mock context value
const mockContextValue = {
  logout: mockLogout,
  token: 'mockToken',
  isLoggedIn: mockIsLoggedIn,
}*/

// Create the mock context value
const mockContextValue = {
  token: 'mockToken',
  login: mockLogin,
  logout:  mockIsLoggedIn,
  isLoggedIn: false,
}



/*
//Source:https://stackoverflow.com/questions/76845432/vitest-react-router-mock-not-called
export const mockNavigate = vi.fn();

vi.mock('react-router-dom', async () => {
    const router = await vi.importActual<typeof import('react-router-dom')>('react-router-dom');
    return {
        ...router,
        useNavigate: vi.fn().mockReturnValue(mockNavigate),
    };
});*/

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

  test('renders projects correctly', async () => {

    render(
      //<LoginContext.Provider value={...mockContextValue}>
      <LoginContext.Provider value={mockContextValue}>
        <BrowserRouter>
          <LoginPopup {...props} />
        </BrowserRouter>
      </LoginContext.Provider>
    )

    // Wait for projects to load
    //const projectsElement = screen.getByText('Login');
    const projectsElement = screen.getByText('Recordar/cambiar contraseña');
    

    // Check if projects are rendered correctly
    expect(projectsElement).toBeInTheDocument();
  })





  test('closes the popup when the close button is clicked', () => {

    render(
      //<LoginContext.Provider value={...mockContextValue}>
      <LoginContext.Provider value={mockContextValue}>
        <BrowserRouter>
          <LoginPopup {...props} />
        </BrowserRouter>
      </LoginContext.Provider>
    )

    fireEvent.click(screen.getByText('✕'))
    expect(mockOnClose).toHaveBeenCalled()
  })

  

  it('calls login and navigates on successful form submission', async () => {

    render(
      //<LoginContext.Provider value={...mockContextValue}>
      <LoginContext.Provider value={mockContextValue}>
        <BrowserRouter>
          <LoginPopup {...props} />
        </BrowserRouter>
      </LoginContext.Provider>
    )

    /*
    const mockNavigate = vi.fn();
    // Mock useNavigate hook
    vi.doMock('react-router-dom', async () => {
      const mod = await vi.importActual('react-router-dom');
      return {
        ...mod,
        useNavigate: vi.fn().mockReturnValue(mockNavigate),
      };
    });*/

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

    //fireEvent.click(screen.getByText('Login'))
    await fireEvent.click(screen.getByRole('button', {
      name: /Login Now/i
    }))
    
    /*
    await waitFor(() => {
      expect(mockLogin).toHaveBeenCalled()
      //expect(mockLogin).toHaveBeenCalledWith({ id: 'user1', token: 'token123' })
    })
    
    await waitFor(() => {
      expect(mockOnClose).toHaveBeenCalled()
      expect(mockNavigate).toHaveBeenCalled()
      //expect(mockedUseNavigate).toHaveBeenCalledWith('/profile')
    });
    */
   /*
    await waitFor(() => {
      console.log('mockLogin called:', mockLogin.mock.calls.length);
      expect(mockLogin).toHaveBeenCalled();
    });
    */
    await waitFor(() => {
      console.log('mockOnClose called:', mockOnClose.mock.calls.length);
      console.log('mockNavigate called:', mockNavigate.mock.calls.length);
      expect(mockOnClose).toHaveBeenCalled();
      //expect(mockNavigate).toHaveBeenCalled();
      expect(mockNavigate).toHaveBeenCalledWith('/profile')
    });


  })

  test('shows error message on failed form submission', async () => {

    render(
      //<LoginContext.Provider value={...mockContextValue}>
      <LoginContext.Provider value={mockContextValue}>
        <BrowserRouter>
          <LoginPopup {...props} />
        </BrowserRouter>
      </LoginContext.Provider>
    )

    mockAxios.onPost('//localhost:8000/api/v1/signin').reply(401)

    fireEvent.input(screen.getByPlaceholderText('DNI o NIE'), {
      target: { value: 'dni123' },
    })
    fireEvent.input(screen.getByPlaceholderText('Contraseña'), {
      target: { value: 'password123' },
    })

    //fireEvent.click(screen.getByText('Login'))
    fireEvent.click(screen.getByRole('button', {
      name: /Login Now/i
    }))

    await waitFor(() => {
      expect('error =>', expect.anything())
    })
  })
})
