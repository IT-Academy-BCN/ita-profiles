import '@testing-library/jest-dom'
import { screen, render } from '@testing-library/react'
import AdditionalTrainingCard from '../../../components/studentDetailCards/additionalTrainingSection/AdditionalTrainingCard'
import { SelectedStudentIdContext } from '../../../context/StudentIdContext'
import { configureMockAdapter } from '../../setup'

const mock = configureMockAdapter()
const studentUUID = 'abc'
const setStudentUUID = () => {}

describe('AdditionalTrainingCard', () => {
  it('should render AdditionalTrainingCard component correctly', () => {
    const { container } = render(<AdditionalTrainingCard />)
    expect(container).toBeInTheDocument()
  })

  it('should fetch the student Additional Training correctly', async () => {
    const additionalTraining = [
      {
        uuid: '123',
        course_name: 'React Bootcamp',
        study_center: 'IT academy',
        course_beginning_year: 2023,
        course_ending_year: 2024,
        duration_hrs: 100,
      },
    ]
    mock
      .onGet(`//localhost:8000/api/v1/student/${studentUUID}/resume/additionaltraining`)
      .reply(200, additionalTraining)

    render(
      <SelectedStudentIdContext.Provider value={{ studentUUID, setStudentUUID }}>
        <AdditionalTrainingCard />
      </SelectedStudentIdContext.Provider>,
    )
    expect(screen.getByText('Otra formación')).toBeInTheDocument()
  })
})
