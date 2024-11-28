import { BrowserRouter, Route, Routes } from 'react-router-dom'
import { useEffect } from 'react'
import { ToastContainer } from 'react-toastify'
import SmallScreenProvider from './context/SmallScreenContext'
import Home from './pages/Home'
import StudentProfilePage from './pages/StudentProfilePage'
import './styles/App.css'
import 'react-toastify/dist/ReactToastify.css';
import ProtectedRoute from './utils/ProtectedRoutes'
import { useLogin } from './context/LoginContext'
import { useToastConsoleErrorListenerHook } from './hooks/notifications/useToastConsoleErrorListenerHook'

const App = () => {
  const { isLoggedIn } = useLogin();
  const { consoleLogDevelper } = useToastConsoleErrorListenerHook()
  useEffect(() => {
    consoleLogDevelper()
  }, [])
  return (
    <>
      <SmallScreenProvider>
        <BrowserRouter>
          <Routes>
            <Route path='/' element={<Home />} />
            <Route element={<ProtectedRoute canActivate={isLoggedIn} redirectPath='/' />}>
              <Route path='/profile' element={<StudentProfilePage />} />
            </Route>
          </Routes>
        </BrowserRouter>
        {process.env.NODE_ENV === 'development' && <ToastContainer />}
      </SmallScreenProvider>
      {process.env.NODE_ENV === 'development' && <ToastContainer />}
    </>
  );
};

export default App