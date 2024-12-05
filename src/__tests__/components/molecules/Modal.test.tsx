import { render, screen, fireEvent } from "@testing-library/react";
import { FC, useState } from "react";
import { vi } from "vitest";
import Modal from "../../../components/molecules/Modal";


const ModalComponentMock: FC = () => {
  const [open, setOpen] = useState<boolean>(false)
  return (
    <>
      <button type="button" aria-label="btn-toggle" onClick={() => setOpen(state => !state)}>Toggle Modal</button>
      <Modal isOpen={open} onClose={() => setOpen(() => false)}>
        <div>Test Modal Content</div>
      </Modal>
    </>
  )
}

describe("Modal Component", () => {

  test("should render modal content when isOpen is true", () => {
    render(
      <Modal isOpen onClose={vi.fn()}>
        <div>Test Modal Content</div>
      </Modal>
    );

    expect(screen.getByText("Test Modal Content")).toBeInTheDocument();

    expect(screen.getByRole("button", { name: "modal-close" })).toBeInTheDocument();

  });

  test("should not render anything when isOpen is false", () => {
    render(
      <Modal isOpen={false} onClose={vi.fn()}>
        <div>Test Modal Content</div>
      </Modal>
    );

    expect(screen.queryByText("Test Modal Content")).not.toBeInTheDocument();

  });

  test("should call onClose when overlay is clicked", () => {
    const mockOnClose = vi.fn();
    render(
      <Modal isOpen onClose={mockOnClose}>
        <div>Test Modal Content</div>
      </Modal>
    );

    fireEvent.click(screen.getByRole("button", { name: "modal-overlay" }));

    expect(mockOnClose).toHaveBeenCalledTimes(1);

  });

  test("should not call onClose when modal content is clicked", () => {
    const mockOnClose = vi.fn();

    render(
      <Modal isOpen onClose={mockOnClose}>
        <div>Test Modal Content</div>
      </Modal>
    );

    fireEvent.click(screen.getByRole("button", { name: "modal-content" }));

    expect(mockOnClose).not.toHaveBeenCalled();

  });

  test("should call onClose when close button is clicked", () => {
    const mockOnClose = vi.fn();
    render(
      <Modal isOpen onClose={mockOnClose}>
        <div>Test Modal Content</div>
      </Modal>
    );

    fireEvent.click(screen.getByRole("button", { name: "modal-close" }));

    expect(mockOnClose).toHaveBeenCalledTimes(1);

  });

  test("should call onClose when Escape key is pressed on modal-content", () => {
    const mockOnClose = vi.fn();
    render(
      <Modal isOpen onClose={mockOnClose}>
        <div>Test Modal Content</div>
      </Modal>
    );

    fireEvent.keyDown(screen.getByRole("button", { name: "modal-content" }), { key: "Escape" });

    expect(mockOnClose).toHaveBeenCalledTimes(1);

  });

  test("should call onClose when Space key is pressed on modal-content", () => {
    const mockOnClose = vi.fn();
    render(
      <Modal isOpen onClose={mockOnClose}>
        <div>Test Modal Content</div>
      </Modal>
    );

    fireEvent.keyDown(screen.getByRole("button", { name: "modal-content" }), { key: " " });

    expect(mockOnClose).toHaveBeenCalledTimes(1);

  });

  it('should toggle the modal state when the button is clicked', () => {
    const { queryByText, getByText, getByRole } = render(
      <ModalComponentMock />
    );

    expect(queryByText(/Test Modal Content/i)).not.toBeInTheDocument();
    const toggle = getByRole("button", { name: 'btn-toggle' })

    fireEvent.click(toggle)

    expect(getByText(/Test Modal Content/i)).toBeInTheDocument();

    fireEvent.click(toggle)

    expect(queryByText(/Test Modal Content/i)).not.toBeInTheDocument();
  })

});