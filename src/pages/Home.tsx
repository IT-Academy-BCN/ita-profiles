import React from 'react';
import { Link} from 'react-router-dom';
import Landing from '../components/landing/Landing';

const Home: React.FC = () => (
    <div className="home-page">
      <Landing />
      <Link to="/profile"><p className='absolute bottom-10 left-10'>Go to profile</p></Link>
    </div>
  );

export default Home;
