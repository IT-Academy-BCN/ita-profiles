import axios from 'axios';
// eslint-disable-next-line import/no-extraneous-dependencies
import MockAdapter from 'axios-mock-adapter';
import { FetchStudentsListHome } from '../../../api/FetchStudentsList';

const mockAxios = new MockAdapter(axios);

describe('FetchStudentsListHome function', () => {
  afterEach(() => {
    mockAxios.reset();
  });

  it('should fetch student list for home', async () => {
    const selectedRoles = ['role1', 'role2'];

    const expectedUrl = 'https://itaperfils.eurecatacademy.org/api/v1/student/list/for-home?specialization=role1,role2';

    const mockData = [{ id: 1, name: 'Student 1' }, { id: 2, name: 'Student 2' }];

    mockAxios.onGet(expectedUrl).reply(200, mockData);

    const result = await FetchStudentsListHome(selectedRoles);

    expect(result).toEqual(mockData);
  });

  it('should handle errors', async () => {
    const selectedRoles: string[] = [];

    const expectedUrl = 'https://itaperfils.eurecatacademy.org/api/v1/student/list/for-home';

    mockAxios.onGet(expectedUrl).reply(500);

    await expect(FetchStudentsListHome(selectedRoles)).rejects.toThrow();
  });
});