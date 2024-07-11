import React from 'react';
import { render, screen, fireEvent } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { LoginProvider, useLogin } from '../../context/LoginContext';

const LoginContextTestComponent: React.FC = () => {
  const { token2, login, logout, isLoggedIn } = useLogin();

  return (
    <div>
      <div>Token: {token2}</div>
      <div>Is Logged In: {isLoggedIn.toString()}</div>
      <button onClick={() => login({ id: '1', token: 'test-token' })}>Login</button>
      <button onClick={logout}>Logout</button>
    </div>
  );
};

describe('LoginProvider', () => {
  afterEach(() => {
    localStorage.clear();
  });

  it('should login a user and set the token', () => {
    render(
      <LoginProvider>
        <LoginContextTestComponent />
      </LoginProvider>
    );

    fireEvent.click(screen.getByText('Login'));

    expect(screen.getByText('Token: test-token')).toBeInTheDocument();
    expect(screen.getByText('Is Logged In: true')).toBeInTheDocument();
    expect(localStorage.getItem('token')).toBe('test-token');
  });

  it('should logout a user and clear the token', () => {
    render(
      <LoginProvider>
        <LoginContextTestComponent />
      </LoginProvider>
    );

    fireEvent.click(screen.getByText('Login'));
    fireEvent.click(screen.getByText('Logout'));

    expect(screen.getByText('Token:')).toBeInTheDocument();
    expect(screen.getByText('Is Logged In: false')).toBeInTheDocument();
    expect(localStorage.getItem('token')).toBeNull();
  });

  it('should initialize isLoggedIn based on localStorage', () => {
    localStorage.setItem('token', 'stored-token');
    
    render(
      <LoginProvider>
        <LoginContextTestComponent />
      </LoginProvider>
    );

    expect(screen.getByText('Token: stored-token')).toBeInTheDocument();
    expect(screen.getByText('Is Logged In: true')).toBeInTheDocument();
  });
});
