import { render } from '@testing-library/react'
import axios from 'axios'
import MockAdapter from 'axios-mock-adapter'
import { Provider } from 'react-redux'
import StudentDetailCard from '../../../../../components/students/studentDetail/cards/StudentDetailCard'
import { store } from '../../../../../store/store'

describe('StudentDataCard', () => {
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

    const studentUUID = '123'

    const aboutData = [
        {
            id: 1,
            name: 'John',
            surname: 'Doe',
            subtitle: 'Software Developer',
            social_media: {
                github: { url: 'https://github.com/johndoe' },
                linkedin: { url: 'https://linkedin.com/in/johndoe' },
            },
            about: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
            tags: [
                { id: 1, name: 'React' },
                { id: 2, name: 'JavaScript' },
            ],
        },
    ]

    test('renders student data correctly', async () => {
        mock.onGet(
            `//localhost:8000/api/v1/student/${studentUUID}/resume/detail`,
        ).reply(200, aboutData)

        render(
            <Provider store={store}>
                <StudentDetailCard />
            </Provider>,
        )
    })
})
