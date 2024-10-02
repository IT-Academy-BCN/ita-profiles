import { createContext, useContext, useState, useEffect, useMemo } from 'react';
import { UserResponseData } from '../interfaces/interfaces';

interface LoginContextProps {
  token: string | null;
  login: (user: UserResponseData) => void;
  logout: () => void;
  isLoggedIn: boolean;
}

const LoginContext = createContext<LoginContextProps | undefined>(undefined);

const LoginProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [token, setToken] = useState<string | null>(localStorage.getItem('token'));
  const [isLoggedIn, setIsLoggedIn] = useState<boolean>(false);

  const login = (user: UserResponseData) => {
    setToken(user.token);
    localStorage.setItem('token', user.token);
    localStorage.setItem('studentID', user.studentID);
    setIsLoggedIn(true);
  };

  const logout = () => {
    localStorage.removeItem('token');
    localStorage.removeItem('studentID');
    setToken(null);
    setIsLoggedIn(false);
  };

  useEffect(() => {
    const storedToken = localStorage.getItem('token');
    setIsLoggedIn(Boolean(storedToken));
    /* console.log("token cambió:", token); */
  }, [token]);

  useEffect(() => {
    /* console.log("isLoggedIn cambió:", isLoggedIn); */
  }, [isLoggedIn]);

  const contextValue = useMemo(() => ({
    token,
    login,
    logout,
    isLoggedIn
  }), [token, isLoggedIn]);

  return (
    <LoginContext.Provider value={contextValue}>
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