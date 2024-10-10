import { Provider } from 'react-redux'
import { render } from '../../../test-utils'
import { store } from '../../../../store/store'
import StudentDetailsLayout from '../../../../components/students/studentDetail/StudentDetailsLayout'

describe('StudentDetailsLayout', () => {
    it('should render the studentDetailsLayout component correctly', () => {
        const { container } = render(
            <Provider store={store}>
                <StudentDetailsLayout />
            </Provider>,
        )
        expect(container).toBeInTheDocument()
    })
})
