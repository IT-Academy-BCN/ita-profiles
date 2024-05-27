// LoginProvider.tsx
import React, { createContext, useContext, useState, useEffect } from 'react';

interface LoginContextProps {
  token: string | null;
  login: (token: string) => void;
  logout: () => void;
  isLoggedIn: boolean;
}

const LoginContext = createContext<LoginContextProps | undefined>(undefined);

const LoginProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [token, setToken] = useState<string | null>(() => localStorage.getItem('token'));
  const [isLoggedIn, setIsLoggedIn] = useState<boolean>(Boolean(token));

  const login = (token: string) => {
    setToken(token);
    localStorage.setItem('token', token);
    setIsLoggedIn(true);
  };

  const logout = () => {
    setToken(null);
    localStorage.removeItem('token');
    setIsLoggedIn(false);
  };

  useEffect(() => {
    const storedToken = localStorage.getItem('token');
    setIsLoggedIn(Boolean(storedToken)); // Actualizar isLoggedIn cuando cambie el token almacenado
  }, []);
  

  return (
    <LoginContext.Provider value={{ token, login, logout, isLoggedIn }}>
      {children}
    </LoginContext.Provider>
  );
};

const useLogin = (): LoginContextProps => {
  const context = useContext(LoginContext);
  if (context === undefined) {
    throw new Error('useLogin must be used within a LoginProvider');
  }
  return context;
};

export { LoginProvider, useLogin, LoginContext };
