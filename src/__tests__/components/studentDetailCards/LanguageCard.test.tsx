import { render, screen } from '@testing-library/react';
import axios from 'axios';
import MockAdapter from 'axios-mock-adapter';
import LanguagesCard from '../../../components/studentDetailCards/languagesSection/LanguagesCard';
import { SelectedStudentIdContext } from '../../../context/StudentIdContext';

describe('LanguagesCard component', () => {
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

  const studentUUID = '123'; // You can replace this with a sample UUID
  const setStudentUUID = () => {}
  const languagesData = [
    { language_id: 1, language_name: 'Spanish' },
    { language_id: 2, language_name: 'English' },
  ];

  test('renders languages correctly', async () => {

    mock.onGet(`//localhost:8000/api/v1/students/${studentUUID}/languages`).reply(200, { languages: languagesData });

    render(
      <SelectedStudentIdContext.Provider
        value={{ studentUUID, setStudentUUID }}
      >
        <LanguagesCard />
      </SelectedStudentIdContext.Provider>,
    )

    // Wait for languages to load
    const languageElements = await screen.findAllByRole('listitem');

    // Check if languages are rendered correctly
    expect(languageElements).toHaveLength(2);
    expect(languageElements[0]).toHaveTextContent('Spanish');
    expect(languageElements[1]).toHaveTextContent('English');
  });

  test('renders error message when request fails', async () => {

    mock.onGet(`//localhost:8000/api/v1/students/${studentUUID}/languages`).reply(500, { error: 'Internal Server Error' });

    render(
      <SelectedStudentIdContext.Provider
        value={{ studentUUID, setStudentUUID }}
      >
        <LanguagesCard />
      </SelectedStudentIdContext.Provider>,
    )

    // Wait for error message to appear
    const errorMessage = await screen.findByText('Request failed with status code 500');

    // Check if error message is rendered correctly
    expect(errorMessage).toBeInTheDocument();
  });
});
