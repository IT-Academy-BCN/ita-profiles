import React from 'react';

interface CompletionPercentageProps {
  completion: number;
}

const CompletionPercentage: React.FC<CompletionPercentageProps> = ({ completion }) => {
  return (
    <div className="profile-progress">
      <p>{completion}% completado</p>
      <div className="progress-bar">
        <div className="progress" style={{ width: `${completion}%` }}></div>
      </div>
    </div>
  );
};

export default CompletionPercentage; //profileProgress
