import { render, screen, waitFor } from '@testing-library/react'
import { describe, test, expect } from 'vitest'
import axios from 'axios'
import MockAdapter from 'axios-mock-adapter'
import BootcampCard from '../../../components/studentDetailCards/bootcampSection/BootcampCard'
import {
  SelectedStudentIdContext,
  SelectedStudentProvider,
} from '../../../context/StudentIdContext'

describe('BootcampCard', () => {
  beforeEach(() => {
    render(
      <SelectedStudentProvider>
        <BootcampCard />
      </SelectedStudentProvider>,
    )
  })
  test('should show "Bootcamp" all the time', () => {
    expect(screen.getByText('Datos del bootcamp')).toBeInTheDocument()
  })
})

describe('BootcampCard component', () => {
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
  const bootcampData = [
    {
      bootcamp_id: '1',
      bootcamp_name: 'Front End React',
      bootcamp_end_date: 'November 2023',
    },
    {
      bootcamp_id: '2',
      bootcamp_name: 'Data Analyst',
      bootcamp_end_date: 'November 2022',
    },
  ]

  test('renders bootcamp data correctly', async () => {
    mock
      .onGet(
        `/api/v1/students/${studentUUID}/bootcamp`,
      )
      .reply(200, { bootcamps: bootcampData })

    render(
      <SelectedStudentIdContext.Provider
        value={{ studentUUID, setStudentUUID }}
      >
        <BootcampCard />
      </SelectedStudentIdContext.Provider>,
    )

    // Wait for bootcamp name to load
    await waitFor(() => {
      expect(screen.getByText('Datos del bootcamp')).toBeInTheDocument()
      expect(screen.getByText('Front End React')).toBeInTheDocument()
      expect(screen.getByText('Data Analyst')).toBeInTheDocument()
    })
  })
})
