import axios from 'axios';
import MockAdapter from 'axios-mock-adapter';
import { render, RenderResult, waitFor } from '@testing-library/react';
import { act } from 'react-dom/test-utils';
import StudentFiltersProvider from '../../../components/studentFilters/StudentFiltersContent';
import { StudentFiltersContext } from '../../../context/StudentFiltersContext';

describe('StudentFiltersProvider', () => {
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

  const selectedRoles: string[] = [];
  const addRole = () => { };
  const removeRole = () => { };

  const value = {
    selectedRoles,
    addRole,
    removeRole,
  };

  const rolesData: string[] | undefined = [];
  const developmentData: string[] | undefined = [];

  test('renders student filters correctly', async () => {
    // Mock API responses
    mock
      .onGet('//localhost:8000/api/v1/specialization/list')
      .reply(200, rolesData);

    mock
      .onGet('//localhost:8000/api/v1/development/list')
      .reply(200, developmentData);

    let getByText: RenderResult['getByText'];

    // Render the component
    await act(async () => {
        const renderResult = render(
          <StudentFiltersContext.Provider value={value}>
            <StudentFiltersProvider />
          </StudentFiltersContext.Provider>
        );
        getByText = renderResult.getByText;

        // Wait for data to be fetched and rendered
        await waitFor(() => {
          rolesData.forEach((role) => {
            expect(getByText(role)).toBeInTheDocument();
          });

          developmentData.forEach((development) => {
            expect(getByText(development)).toBeInTheDocument();
          });
        });
      });
  });
});
