import SmallScreenProvider from './context/SmallScreenContext'
import Home from './pages/Home'
import './styles/App.css'

const App = () => (
  <SmallScreenProvider>
    <Home />
  </SmallScreenProvider>
)

export default App
