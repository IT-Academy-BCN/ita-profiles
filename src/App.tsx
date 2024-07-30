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
import toastConsoleErrorListener from './lib/utils/toastConsoleErrorListener'

const App = () => {
  const { isLoggedIn } = useLogin();

  useEffect(() => {
    toastConsoleErrorListener()
  }, [])

  return (
    <SmallScreenProvider>
      <BrowserRouter>
        <Routes>
          <Route path='/' element={<Home />} />
          <Route element={<ProtectedRoute canActivate={isLoggedIn} redirectPath='/' />}>
            <Route path='/profile' element={<StudentProfilePage />} />
          </Route>
        </Routes>
      </BrowserRouter>
      <ToastContainer />
    </SmallScreenProvider>
  );
};

export default App