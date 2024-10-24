import { fireEvent, render, screen } from "@testing-library/react"
import { Provider } from "react-redux"
import { store } from "../../store/store" 
import StudentDetailsContent from "../../components/students/studentDetail/StudentDetailsContent"


describe('StudentDetailsContent', () => {
    test('renders the student details', () => {
        const paneOpenHandler = () => {
            paneOpenHandler.called = true
        }
        paneOpenHandler.called = false
        render(
            <Provider store={store}>
                <StudentDetailsContent handleIsPanelOpen={paneOpenHandler} />
            </Provider>,
        )

        const detailProfile = screen.getByText('Detalle Perfil')
        expect(detailProfile).toBeInTheDocument()

        const closeButton = screen.getByAltText('close icon')
        expect(closeButton).toBeInTheDocument()

        fireEvent.click(closeButton)
        expect(paneOpenHandler.called).toBe(true)
    })

    test('renders all the different cards', () => {
        const paneOpenHandler = () => {
            paneOpenHandler.called = true
        }
        paneOpenHandler.called = false
        render(
            <Provider store={store}>
                <StudentDetailsContent handleIsPanelOpen={paneOpenHandler} />
            </Provider>,
        )

        expect(screen.queryByTestId('StudentDataCard')).toBeVisible()
        expect(screen.queryByTestId('ProjectsCard')).toBeVisible()
        expect(screen.queryByTestId('CollaborationCard')).toBeVisible()
        expect(screen.queryByTestId('BootcampCard')).toBeVisible()
        expect(screen.queryByTestId('AdditionalTrainingCard')).toBeVisible()
        expect(screen.queryByTestId('LanguagesCard')).toBeVisible()
        expect(screen.queryByTestId('ModalityCard')).toBeVisible()
    })
})
