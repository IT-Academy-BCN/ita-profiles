import { render } from '@testing-library/react';
import axios from "axios";
import MockAdapter from 'axios-mock-adapter';
import StudentDataCard from '../../../components/studentDetailCards/studentDataSection/StudentDataCard';
import { SelectedStudentIdContext} from '../../../context/StudentIdContext';

describe('StudentDataCard', () => {
  let mock: MockAdapter;

  beforeAll(() => {
    mock = new MockAdapter(axios);
  });

  afterEach(() => {
    mock.reset();
  });

  afterAll(() => {
    mock.restore();
  });

  const studentUUID = '123';
  const setStudentUUID = () => { };
  const aboutData = [
    {
      id: 1,
      fullname: 'John Doe',
      subtitle: 'Software Developer',
      social_media: {
        github: { url: 'https://github.com/johndoe' },
        linkedin: { url: 'https://linkedin.com/in/johndoe' }
      },
      about: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
      tags: [{ id: 1, name: 'React' }, { id: 2, name: 'JavaScript' }]
    }
  ];

  test('renders student data correctly', async () => {
    mock
      .onGet(
        `/api/v1/student/${studentUUID}/detail/for-home`,
      )
      .reply(200, aboutData);

    render(
      <SelectedStudentIdContext.Provider
        value={{ studentUUID, setStudentUUID }}
      >
        <StudentDataCard />
      </SelectedStudentIdContext.Provider>,
    );



  });


});
