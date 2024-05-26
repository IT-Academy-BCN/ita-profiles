import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import SmallScreenProvider from './context/SmallScreenContext';
import Home from './pages/Home';
import StudentProfile from './components/studentProfile/StudentProfile';
import './styles/App.css';

const App: React.FC = () => (
  <SmallScreenProvider>
    <Router>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/profile" element={<StudentProfile />} />
      </Routes>
    </Router>
  </SmallScreenProvider>
);

export default App;
