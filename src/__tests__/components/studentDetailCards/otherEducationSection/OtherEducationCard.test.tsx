import '@testing-library/jest-dom'
import { screen, render } from '@testing-library/react'
import OtherEducationCard from '../../../../components/studentDetailCards/otherEducationSection/OtherEducationCard'
import { SelectedStudentIdContext } from '../../../../context/StudentIdContext'
import { configureMockAdapter } from '../../../setup'

const mock = configureMockAdapter()
const baseApi = 'https://itaperfils.eurecatacademy.org'
const studentUUID = 'abc'
const setStudentUUID = () => {}

describe('OtherEducationCard', () => {
  it('should render OtherEducationCard component correctly', () => {
    const { container } = render(<OtherEducationCard />)
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
      .onGet(`${baseApi}/api/v1/students/${studentUUID}/additionaltraining`)
      .reply(200, additionalTraining)

    render(
      <SelectedStudentIdContext.Provider
        value={{ studentUUID, setStudentUUID }}
      >
        <OtherEducationCard />
      </SelectedStudentIdContext.Provider>,
    )
    expect(screen.getByText('Otra formación')).toBeInTheDocument()
  })
})
