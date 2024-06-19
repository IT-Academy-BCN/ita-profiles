import { render, screen } from '@testing-library/react'
import { describe, test, expect } from 'vitest'
import axios from 'axios'
import MockAdapter from 'axios-mock-adapter'
import ModalityCard from '../../components/studentDetailCards/modalitySection/modalityCard'
import {
  SelectedStudentProvider,
  SelectedStudentIdContext,
} from '../../context/StudentIdContext'

describe('ModalityCard', () => {
  beforeEach(() => {
    render(
      <SelectedStudentProvider>
        <ModalityCard />
      </SelectedStudentProvider>,
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
  const setStudentUUID = () => {}
  const modalityData = {
    modality: ['Presencial', 'Remot'],
  }

  test('renders modalities correctly', async () => {
    mock
      .onGet(
        `//localhost:8000/api/v1/modality/${studentUUID}`,
      )
      .reply(200, modalityData)

    render(
      <SelectedStudentIdContext.Provider
        value={{ studentUUID, setStudentUUID }}
      >
        <ModalityCard />
      </SelectedStudentIdContext.Provider>,
    )

    // Wait for modalities to load
    const modalityElements = await screen.findAllByText(/Presencial|Remot/)

    // Check if modalities are rendered correctly
    expect(modalityElements).toHaveLength(2)
    expect(modalityElements[0]).toHaveTextContent('Presencial')
    expect(modalityElements[1]).toHaveTextContent('Remot')
  })
})
