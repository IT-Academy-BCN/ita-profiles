import React from 'react';
import { render, screen, fireEvent } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { LoginProvider, useLogin } from '../../context/LoginContext';

const LoginContextTestComponent: React.FC = () => {
  const { token, login, logout, isLoggedIn } = useLogin();
  const studentID = localStorage.getItem('studentSUID');

  return (
    <div>
      <div>Token: {token}</div>
      <div>Is Logged In: {isLoggedIn.toString()}</div>
      <div>Is Student ID: {studentID}</div>
      <button
        type='button'
        onClick={() => login({ userID: '1', token: 'test-token', studentID: 'test-studentID' })}>
        Login
      </button>
      <button
        type='button'
        onClick={logout}>
        Logout
      </button>
    </div>
  );
};

describe('LoginProvider', () => {
  afterEach(() => {
    localStorage.clear();
  });

  it('should login a user and set the token, studentSUID', () => {
    render(
      <LoginProvider>
        <LoginContextTestComponent />
      </LoginProvider>
    );

    fireEvent.click(screen.getByText('Login'));

    expect(screen.getByText('Token: test-token')).toBeInTheDocument();
    expect(screen.getByText('Is Logged In: true')).toBeInTheDocument();
    expect(screen.getByText('Is Student ID: test-studentID')).toBeInTheDocument();
    expect(localStorage.getItem('token')).toBe('test-token');
    expect(localStorage.getItem('studentSUID')).toBe('test-studentID');
  });

  it('should logout a user and clear the token, studentSUID ', () => {
    render(
      <LoginProvider>
        <LoginContextTestComponent />
      </LoginProvider>
    );

    fireEvent.click(screen.getByText('Login'));
    fireEvent.click(screen.getByText('Logout'));

    expect(screen.getByText('Token:')).toBeInTheDocument();
    expect(screen.getByText('Is Logged In: false')).toBeInTheDocument();
    expect(screen.getByText('Is Student ID:')).toBeInTheDocument();
    expect(localStorage.getItem('token')).toBeNull();
    expect(localStorage.getItem('studentSUID')).toBeNull();
  });

  it('should initialize isLoggedIn based on localStorage', () => {
    localStorage.setItem('token', 'stored-token');
    localStorage.setItem('studentSUID', 'test-studentID');
    render(
      <LoginProvider>
        <LoginContextTestComponent />
      </LoginProvider>
    );

    expect(screen.getByText('Token: stored-token')).toBeInTheDocument();
    expect(screen.getByText('Is Logged In: true')).toBeInTheDocument();
    expect(screen.getByText('Is Student ID: test-studentID')).toBeInTheDocument();
  });
});
