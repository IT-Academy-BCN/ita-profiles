import { render, screen, fireEvent } from "@testing-library/react";
import { vi } from "vitest";
import Modal from "../../../components/atoms/modal/Modal";


describe("Modal Component", () => {

  // Se tiene que ver cuando esté abierto
  test("You have to see it when it's open", () => {
    render(
      <Modal isOpen onClose={() => { }}>
        <div>Test Modal Content</div>
      </Modal>
    );
    expect(screen.getByText("Test Modal Content")).toBeInTheDocument();
  });

  // No se debería ver cuando esté cerrado
  test("It should not be visible when closed.", () => {
    const { queryByText } = render(
      <Modal isOpen={false} onClose={() => { }}>
        <div>Test Modal Content</div>
      </Modal>
    );
    expect(queryByText("Test Modal Content")).toBeNull();
  });

  // Llama a onClose cuando se hace clic en la superposición
  test("calls onClose when overlay is clicked", () => {
    const mockOnClose = vi.fn();
    render(
      <Modal isOpen onClose={mockOnClose}>
        <div>Test Modal Content</div>
      </Modal>
    );

    fireEvent.click(screen.getByRole("button", { name: "modal-overlay" }));
    expect(mockOnClose).toHaveBeenCalled();
  });
});