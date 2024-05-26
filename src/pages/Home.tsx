import React from 'react';
import { useNavigate} from 'react-router-dom';
import Landing from '../components/landing/Landing';

const Home: React.FC = () => {
  const navigate = useNavigate();

  const handleNavigation = (path: string) => {
    navigate(path);
  };

  return (
    <div className="home-page">
      <Landing />
      <button onClick={() => handleNavigation('/profile')}>Go to Profile</button>
    </div>
  );
};

export default Home;
