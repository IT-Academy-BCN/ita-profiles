import '@testing-library/jest-dom'
import { screen, render } from '@testing-library/react'
import { Provider } from 'react-redux'
import AdditionalTrainingCard from '../../../components/studentDetailCards/additionalTrainingSection/AdditionalTrainingCard'
import { configureMockAdapter } from '../../setup'
import { store } from '../../../store/store'

const mock = configureMockAdapter()
const studentUUID = 'abc'

describe('AdditionalTrainingCard', () => {
  it('should render AdditionalTrainingCard component correctly', () => {
    const { container } = render(<Provider store={store}><AdditionalTrainingCard /></Provider>)
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
      <Provider store={store}>
        <AdditionalTrainingCard />
      </Provider>,
    )
    expect(screen.getByText('Otra formación')).toBeInTheDocument()
  })
})
