import ProfileProgress from './ProfileProgress';
import LikeIcon from '../../assets/svg/like.svg';
import CheckedIcon from '../../assets/img/likeChecked.png'

const items = [
  { text: 'Nombre, título, gitHub y Linkedin', checked: true },
  { text: 'Presentación', checked: true },
  { text: 'Skills', checked: true },
  { text: 'Proyectos', checked: true },
  { text: 'Colaboración', checked: false },
  { text: 'Formación', checked: false },
  { text: 'Idiomas', checked: false },
  { text: 'Modalidad de empleo', checked: false },
];

// eslint-disable-next-line @typescript-eslint/no-shadow
const calculateCompletionPercentage = (items: { text: string; checked: boolean }[]) => {
  const totalItems = items.length;
  const completedItems = items.filter(item => item.checked).length;
  return (completedItems / totalItems) * 100;
};

const completionPercentage = calculateCompletionPercentage(items);

const CompletedSteps = () => (
  <>
    <ProfileProgress completion={completionPercentage} />
    <ul className="list-none p-0">
      {items.map((item) => (
        <li className={`my-2 font-semibold flex ${item.checked ? 'text-primary' : 'text-gray-3'}`}>
                    {item.checked ? (
            <img src={CheckedIcon} alt="like" className="mr-2 w-6 h-6" />
          ) : (
            <img src={LikeIcon} alt="dislike" className="mr-2" />
          )}

          {item.text}
        </li>
      ))}
    </ul>
  </>
);

export default CompletedSteps;