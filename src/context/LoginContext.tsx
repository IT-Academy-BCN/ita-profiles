// LoginProvider.tsx
import React, { createContext, useContext, useState, useEffect } from 'react';

interface LoginContextProps {
  token: string | null;
  login: (token: string) => void;
  logout: () => void;
}

const LoginContext = createContext<LoginContextProps | undefined>(undefined);

const LoginProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [token, setToken] = useState<string | null>(() => localStorage.getItem('token'));

  const login = (token: string) => {
    setToken(token);
    localStorage.setItem('token', token);
  };

  const logout = () => {
    setToken(null);
    localStorage.removeItem('token');
  };

  useEffect(() => {
    const storedToken = localStorage.getItem('token');
    if (storedToken) {
      setToken(storedToken);
    }
  }, []);

  return (
    <LoginContext.Provider value={{ token, login, logout }}>
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

export { LoginProvider, useLogin };
