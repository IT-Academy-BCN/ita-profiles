import { createContext, useContext, useState, useEffect } from 'react';

interface LoginContextProps {
  token2: string | null;
  login: (user: {id: string, token: string}) => void;
  logout: () => void;
  isLoggedIn: boolean;
}

const LoginContext = createContext<LoginContextProps | undefined>(undefined);

const LoginProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [token, setToken] = useState<string | null>(null);
  const [isLoggedIn, setIsLoggedIn] = useState<boolean>(false);

  const login = (user: {id: string, token: string}) => {
    setToken(user.token);
    localStorage.setItem('token', user.token);
    setIsLoggedIn(true);
  };

  const logout = () => {
    localStorage.removeItem('token');
    setToken(null);
    setIsLoggedIn(false);
    
  };

  useEffect(() => {
    const storedToken = localStorage.getItem('token');
    setIsLoggedIn(Boolean(storedToken)); 
    console.log("token cambió:", token);
  }, [token]);

  useEffect(() => {
    console.log("isLoggedIn cambió:", isLoggedIn);
  }, [isLoggedIn]);


  return (
    <LoginContext.Provider value={{ token2: token, login, logout, isLoggedIn }}>
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