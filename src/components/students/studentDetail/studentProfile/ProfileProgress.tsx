import React from 'react';

interface CompletionPercentageProps {
  completion: number;
}

const ProfileProgress: React.FC<CompletionPercentageProps> = ({ completion }) => (
  <div className="mb-8">
    <p className="text-lg font-bold text-black-3 pb-3">{completion}% completado</p>
    <div className="w-full bg-gray-3 rounded-full h-1.5">
      <div className="bg-primary h-1.5 rounded-full" style={{ width: `${completion}%` }} />
    </div>
  </div>
);

export default ProfileProgress;