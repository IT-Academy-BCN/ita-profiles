import { Provider } from 'react-redux'
import { render, screen, waitFor } from '@testing-library/react'
import { describe, expect } from 'vitest'
import axios from 'axios'
import MockAdapter from 'axios-mock-adapter'
import { store } from '../../../../../store/store'
import BootcampCard from '../../../../../components/students/studentDetail/cards/BootcampCard'

describe('BootcampCard component', () => {
    it('renders bootcamp data correctly', () => {
        const mock = new MockAdapter(axios)
        const mockResponse = {
            data: {
                bootcamps: [
                    {
                        bootcamp_id: 'c24ce043-a214-454e-8152-d3255722f70c',
                        bootcamp_name: 'Reskilling - Full Stack PHP',
                        bootcamp_end_date: '2023-10-07',
                    },
                    {
                        bootcamp_id: '9bd21470-db24-4ce3-b838-c4d3847785d1',
                        bootcamp_name: 'Fullstack PHP',
                        bootcamp_end_date: '2023-11-05',
                    },
                ],
            },
        }
        mock.onGet(
            `//localhost:8000/api/v1/student/c24ce043-a214-454e-8152-d3255722f70c/resume/bootcamp`,
        ).reply(200, mockResponse)

        render(
            <Provider store={store}>
                <BootcampCard />
            </Provider>,
        )
        expect(screen.getByText('Datos del bootcamp')).toBeInTheDocument()

        waitFor(() =>
            expect(
                screen.getByText('Reskilling - Full Stack PHP'),
            ).toBeInTheDocument(),
        )
        waitFor(() =>
            expect(screen.getByText('Fullstack PHP')).toBeInTheDocument(),
        )
    })
})
