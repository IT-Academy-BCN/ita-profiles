import { BrowserRouter, Route, Routes } from 'react-router-dom'
import SmallScreenProvider from './context/SmallScreenContext'
import Home from './pages/Home'
import StudentProfilePage from './pages/StudentProfilePage'
import './styles/App.css'
import ProtectedRoute from './utils/ProtectedRoutes'
import { useLogin } from './context/LoginContext'

const App = () => {
  const { isLoggedIn } = useLogin();

  return (
    <SmallScreenProvider>
      <BrowserRouter>
        <Routes>
          <Route path='/' element={<Home />}/>
          <Route element={<ProtectedRoute canActivate={isLoggedIn} redirectPath='/' />}>
            <Route path='/profile' element={<StudentProfilePage />} />
          </Route>
        </Routes>
      </BrowserRouter>
    </SmallScreenProvider>
  );
};

export default App