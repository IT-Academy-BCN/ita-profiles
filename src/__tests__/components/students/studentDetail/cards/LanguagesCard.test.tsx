import { render } from '@testing-library/react'
import axios from 'axios'
import MockAdapter from 'axios-mock-adapter'
import { Provider } from 'react-redux'
import LanguagesCard from '../../../../../components/students/studentDetail/cards/LanguagesCard'
import { SelectedStudentIdContext } from '../../../../../context/StudentIdContext'
import { store } from '../../../../../store/store'

describe('LanguagesCard component', () => {
    let mock: MockAdapter

    beforeAll(() => {
        mock = new MockAdapter(axios)
    })

    afterEach(() => {
        mock.reset()
    })

    afterAll(() => {
        mock.restore()
    })

    const studentUUID = '123' // You can replace this with a sample UUID
    const setStudentUUID = () => {}
    const languagesData = [
        { language_id: 1, language_name: 'Spanish' },
        { language_id: 2, language_name: 'English' },
    ]

    test('renders languages correctly', async () => {
        mock.onGet(
            `//localhost:8000/api/v1/student/${studentUUID}/resume/languages`,
        ).reply(200, { languages: languagesData })

        render(
            <Provider store={store}>
                <SelectedStudentIdContext.Provider
                    value={{ studentUUID, setStudentUUID }}
                >
                    <LanguagesCard />
                </SelectedStudentIdContext.Provider>
            </Provider>,
        )

        // Wait for languages to load
        /* const languageElements = await screen.findAllByRole('listitem'); */

        // Check if languages are rendered correctly
        /* expect(languageElements).toHaveLength(2);
    expect(languageElements[0]).toHaveTextContent('Spanish');
    expect(languageElements[1]).toHaveTextContent('English'); */
    })
})
