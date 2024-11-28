import ProfileProgress from './ProfileProgress';
import ThumbsUpGray from '../../../../assets/icons/thumbs-up-gray.png';
import thumbsUpPink from '../../../../assets/icons/thumbs-up-pink.png'

const items = [
  { id: 1, text: 'Nombre, título, gitHub y Linkedin', checked: true },
  { id: 2, text: 'Presentación', checked: true },
  { id: 3, text: 'Skills', checked: true },
  { id: 4, text: 'Proyectos', checked: true },
  { id: 5, text: 'Colaboración', checked: false },
  { id: 6, text: 'Formación', checked: false },
  { id: 7, text: 'Idiomas', checked: false },
  { id: 8, text: 'Modalidad de empleo', checked: false },
];

// eslint-disable-next-line @typescript-eslint/no-shadow
const calculateCompletionPercentage = (items: { text: string; checked: boolean }[]) => {
  const totalItems = items.length;
  const completedItems = items.filter(item => item.checked).length;
  return (completedItems / totalItems) * 100;
};

const completionPercentage = calculateCompletionPercentage(items);

const CompletedSteps = () => (
  <div className="flex flex-col gap-4 w-3/4">
    <ProfileProgress completion={completionPercentage} />
    <ul className="list-none p-0">
      {items.map((item) => (
        <li key={item.id} className={`my-4 font-semibold flex text-xl ${item.checked ? 'text-primary' : 'text-gray-3'}`}>
          {item.checked ? (
            <img src={thumbsUpPink} alt="completed" className="mr-2 w-8 h-8" />
          ) : (
            <img src={ThumbsUpGray} alt="not completed" className="mr-2 w-8 h-8" />
          )}

          {item.text}
        </li>
      ))}
    </ul>

  </div>

);

export default CompletedSteps;