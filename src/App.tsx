import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import SmallScreenProvider from './context/SmallScreenContext';
import { SelectedStudentProvider } from './context/StudentIdContext';
import { StudentProvider } from './context/StudentContext';
import Home from './pages/Home';
import StudentProfile from './components/studentProfile/StudentProfile';
import './styles/App.css';

const App: React.FC = () => (
  <SmallScreenProvider>
    <SelectedStudentProvider>
      <StudentProvider>
        <Router>
          <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/profile" element={<StudentProfile />} />
          </Routes>
        </Router>
      </StudentProvider>
    </SelectedStudentProvider>
  </SmallScreenProvider>
);

export default App;
