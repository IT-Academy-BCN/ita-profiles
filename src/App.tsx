import SmallScreenProvider from './context/SmallScreenContext'
import { BrowserRouter, Route, Routes } from 'react-router-dom'
import Home from './pages/Home'
import StudentProfilePage from './pages/StudentProfilePage'
import './styles/App.css'

const App = () => (
  <SmallScreenProvider>
    <BrowserRouter>
      <Routes>

        <Route
          path='/'
          element={<Home />}
          >
        </Route>

        <Route
          path='/profile'
          element={<StudentProfilePage />}
          >
        </Route>

      </Routes>
    </BrowserRouter>    
  </SmallScreenProvider>
)

export default App
