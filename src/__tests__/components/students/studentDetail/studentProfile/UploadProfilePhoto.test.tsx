import { Provider } from 'react-redux'
import { describe, expect } from 'vitest'
import { render } from '@testing-library/react'
import { store } from '../../../../../store/store'
import UploadProfilePhoto from '../../../../../components/students/studentDetail/studentProfile/studentProfileCards/editStudentProfile/UploadProfilePhoto'
import MyProfileStudentDetailCard from '../../../../../components/students/studentDetail/studentProfile/studentProfileCards/MyProfileStudentDetailCard'

const renderComponent = () => {
    return render(
        <Provider store={store}>
            <MyProfileStudentDetailCard />
        </Provider>,
    )
}

describe('UploadProfilePhoto Component', () => {
    beforeEach(() => {
        renderComponent()
    })

    it('should be defined', () => {
        expect(UploadProfilePhoto).toBeDefined()
    })
})
