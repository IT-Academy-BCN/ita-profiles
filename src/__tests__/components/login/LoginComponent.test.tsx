// LoginPopup.test.tsx
import React from 'react';
import { render, fireEvent, screen, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { useLogin, LoginProvider } from '../../../context/LoginContext'; // Asegúrate de importar correctamente
import LoginPopup from '../../../components/login_&_register/LoginPopup';

// Simulamos la función fetchLogin
const mockFetchLogin = async (data: { dni: string; password: string }) => {
  return { token: 'mocked-token' }; // Devolvemos un token simulado
};

describe('LoginPopup', () => {
  it('should display login form and handle login', async () => {
    const handleClose = jest.fn();

    // Mockeamos el contexto de login
    const loginContextValue = { login: jest.fn() };

    render(
      <LoginProvider >
        <LoginPopup onClose={handleClose} />
      </LoginProvider>
    );

    // Fill out the form
    fireEvent.change(screen.getByPlaceholderText('DNI'), { target: { value: '12345678' } });
    fireEvent.change(screen.getByPlaceholderText('Contraseña'), { target: { value: 'password' } });

    // Submit the form
    fireEvent.click(screen.getByText('Login'));

    // Simulamos la respuesta de la función fetchLogin
    await waitFor(() => {
      expect(loginContextValue.login).toHaveBeenCalledWith('mocked-token');
      expect(handleClose).toHaveBeenCalled();
    });
  });
});
