import { render, screen, waitFor } from '@testing-library/react'
import { describe, test, expect } from 'vitest'
import axios from 'axios'
import MockAdapter from 'axios-mock-adapter'
import { Provider } from 'react-redux'
import ModalityCard from '../../../components/studentDetailCards/modalitySection/modalityCard'
import { store } from '../../../store/store'

describe('ModalityCard', () => {
  beforeEach(() => {
    render(
      <Provider store={store}>
        <ModalityCard />
      </Provider>,
    )
  })
  test('should show "Modalidad" all the time', () => {
    expect(screen.getByText('Modalidad')).toBeInTheDocument()
  })
})

describe('ModalityCard component', () => {
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
  const modalityData = {
    modality: ['Presencial', 'Remot'],
  }

  test('renders modalities correctly', async () => {
    mock
      .onGet(
        `//localhost:8000/api/v1/student/${studentUUID}/resume/modality/`,
      )
      .reply(200, modalityData)

    render(
      <Provider store={store}>
        <ModalityCard />
      </Provider>,
    )

    // Wait for modalities to load

    waitFor(() => expect(screen.getByText('Presencial')).toBeInTheDocument())
    waitFor(() => expect(screen.getByText('Remot')).toBeInTheDocument())
  })
})
