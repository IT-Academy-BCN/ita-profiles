import { render, screen, fireEvent } from "@testing-library/react";
import StudentDetailsContent from "../../components/studentDetail/StudentDetailsContent";

describe("StudentDetailsContent", () => {
  test("renders the student details", () => {
    const paneOpenHandler = () => { paneOpenHandler.called = true }
    paneOpenHandler.called = false;
    render(<StudentDetailsContent handleIsPanelOpen={paneOpenHandler} />);

    const detailProfile = screen.getByText('Detalle Perfil');
    expect(detailProfile).toBeInTheDocument();

    const closeButton = screen.getByAltText("close icon");
    expect(closeButton).toBeInTheDocument();

    fireEvent.click(closeButton);
    expect(paneOpenHandler.called).toBe(true);
  });

  test("renders all the different cards", () => {
    const paneOpenHandler = () => { paneOpenHandler.called = true }
    paneOpenHandler.called = false;
    render(<StudentDetailsContent handleIsPanelOpen={paneOpenHandler} />);

    expect(screen.queryByTestId("StudentDataCard")).toBeVisible();
    expect(screen.queryByTestId("ProjectsCard")).toBeVisible();
    expect(screen.queryByTestId("CollaborationCard")).toBeVisible();
    expect(screen.queryByTestId("BootcampCard")).toBeVisible();
    expect(screen.queryByTestId("AdditionalTrainingCard")).toBeVisible();
    expect(screen.queryByTestId("LanguagesCard")).toBeVisible();
    expect(screen.queryByTestId("ModalityCard")).toBeVisible();
  });
});