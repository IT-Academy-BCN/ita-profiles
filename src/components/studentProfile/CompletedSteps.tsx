import React, { useContext } from 'react';
import ProfileProgress from './ProfileProgress';
import LikeIcon from '../../assets/img/like.png';
import CheckedIcon from '../../assets/img/likeChecked.png';
import { StudentContext } from '../../context/StudentContext';

const calculateCompletionPercentage = (items: { text: string; checked: boolean }[]) => {
  const totalItems = items.length;
  const completedItems = items.filter(item => item.checked).length;
  return (completedItems / totalItems) * 100;
};

const CompletedSteps: React.FC = () => {
  const { studentData } = useContext(StudentContext);

  if (!studentData) {
    return <div>Loading...</div>;
  }

  const items = [
    { text: 'Nombre, título, gitHub y Linkedin', checked: Boolean(studentData.fullname && studentData.social_media.github.url && studentData.social_media.linkedin.url) },
    { text: 'Presentación', checked: Boolean(studentData.subtitle) },
    { text: 'Skills', checked: Boolean(studentData.tags.length > 0) },
    { text: 'Proyectos', checked: Boolean(studentData.about) },
    { text: 'Colaboración', checked: false },
    { text: 'Formación', checked: false },
    { text: 'Idiomas', checked: false },
    { text: 'Modalidad de empleo', checked: false },
  ];

  const completionPercentage = calculateCompletionPercentage(items);

  return (
    <div className="flex flex-col gap-4 w-1/3">
      <ProfileProgress completion={completionPercentage} />
      <ul className="list-none p-0">
        {items.map((item, index) => (
          <li key={index} className={`my-4 font-semibold flex text-xl ${item.checked ? 'text-primary' : 'text-gray-3'}`}>
            {item.checked ? (
              <img src={CheckedIcon} alt="like" className="mr-2 w-8 h-8" />
            ) : (
              <img src={LikeIcon} alt="dislike" className="mr-2 w-8 h-8" />
            )}
            {item.text}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default CompletedSteps;
