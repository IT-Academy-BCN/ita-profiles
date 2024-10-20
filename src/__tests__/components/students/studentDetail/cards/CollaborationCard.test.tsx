import { render, screen, waitFor } from '@testing-library/react'
import { describe, test, expect } from 'vitest'
import axios from 'axios'
import MockAdapter from 'axios-mock-adapter'
import { Provider } from 'react-redux'

import CollaborationCard from '../../../../../components/students/studentDetail/cards/CollaborationCard'
import { store } from '../../../../../store/store'
import {
    SelectedStudentProvider,
    SelectedStudentIdContext,
} from '../../../../../context/StudentIdContext'

describe('CollaborationCard', () => {
    beforeEach(() => {
        render(
            <Provider store={store}>
                <SelectedStudentProvider>
                    <CollaborationCard />
                </SelectedStudentProvider>
            </Provider>,
        )
    })
    test('should show "Collaboration" all the time', () => {
        expect(screen.getByText('Colaboración')).toBeInTheDocument()
    })
})

describe('CollaborationCard component', () => {
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
    const collaborationData = [
        {
            uuid: 'e6b4432b-d2f8-4e06-b727-6ecaf40e6e0e',
            collaboration_name: 'ita-wiki',
            collaboration_description: 'Recursos subidos',
            collaboration_quantity: 9,
        },
        {
            uuid: '9c0863f9-453c-431b-a142-79205cea0fdc',
            collaboration_name: 'ita-challenges',
            collaboration_description: 'Retos completados',
            collaboration_quantity: 7,
        },
    ]

    test('renders collaboration data correctly', async () => {
        mock.onGet(
            `//localhost:8000/api/v1/student/${studentUUID}/resume/collaborations`,
        ).reply(200, { collaborations: collaborationData })

        render(
            <Provider store={store}>
                <SelectedStudentIdContext.Provider
                    value={{ studentUUID, setStudentUUID }}
                >
                    <CollaborationCard />
                </SelectedStudentIdContext.Provider>
            </Provider>,
        )

        await waitFor(() => {
            expect(screen.getByText('ita-wiki')).toBeInTheDocument()
            expect(screen.getByText('Recursos subidos')).toBeInTheDocument()
            expect(screen.getByText('ita-challenges')).toBeInTheDocument()
            expect(screen.getByText('Retos completados')).toBeInTheDocument()
        })
    })
})
