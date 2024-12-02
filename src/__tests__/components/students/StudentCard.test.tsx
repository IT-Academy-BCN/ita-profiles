import { fireEvent, render } from '@testing-library/react'
import { Provider } from 'react-redux'
import StudentCard from '../../../components/students/StudentCard'
import { TStudentList } from '../../../interfaces/interfaces'
import { store } from '../../../store/store'

const mockStudentCard: TStudentList = {
  id: 'abc123',
  fullname: 'John',
  subtitle: 'Doe',
  photo: '/img/stud_2.png',
  tags: [
    { id: 1, name: 'react' },
    { id: 2, name: 'php' },
  ],
}

describe('StudentCard', () => {
  it('should render the student card component', () => {
    const { container } = render(
      <Provider store={store}>
        <StudentCard {...mockStudentCard} />
      </Provider>,
    )
    expect(container).toBeInTheDocument()
  })
  it('should trigger actions correctly on click', () => {
    const { getByText } = render(
      <Provider store={store}>
        <StudentCard {...mockStudentCard} />
      </Provider>,
    )

    fireEvent.click(getByText('John'))

    expect(store.getState().ShowUserReducer.isUserPanelOpen).toBe(true)
  })
})
