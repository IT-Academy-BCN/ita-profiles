import { act, renderHook } from "@testing-library/react";
import { useDragAndDropLanguagesHook } from "../../hooks/useDragAndDropLanguagesHook";

const mockLanguages = [
  {
    id: "d108e5aa-e058-4245-8a9a-e056a1594dfa",
    name: "Francès",
    level: "Intermedi"
  },
  {
    id: "d108e5aa-e058-4245-8a9a-e056a1594dfg",
    name: "Anglais",
    level: "Avançat",
  }
]

describe("UseDragAndDropLanguagesHook", () => {

  it("should render the App component", () => {
    expect(useDragAndDropLanguagesHook).toBeDefined()
  });

  it("Expects to receive an array per parameter of type Languages", () => {

    const { result } = renderHook(() => useDragAndDropLanguagesHook(mockLanguages))

    expect(result.current.updateLanguagesDrop).toEqual([
      {
        id: "d108e5aa-e058-4245-8a9a-e056a1594dfa",
        name: "Francès",
        level: "Intermedi",
      },
      {
        id: "d108e5aa-e058-4245-8a9a-e056a1594dfg",
        name: "Anglais",
        level: "Avançat",
      }
    ])

  });

  it("should initialize draggedItemIndex as null", () => {

    const { result } = renderHook(() => useDragAndDropLanguagesHook(mockLanguages));

    expect(result.current.draggedItemIndex).toBeNull();

  });

  it("should update draggedItemIndex when handleDragStart is called", () => {

    const index: number = 6;
    const { result } = renderHook(() => useDragAndDropLanguagesHook(mockLanguages))

    act(() => {
      result.current.handleDragStart(index)
    })

    expect(result.current.draggedItemIndex).toEqual(6)

  })

  it("should not update draggedItemIndex without calling handleDragStart", () => {
    // Renderizamos el hook con los lenguajes
    const { result } = renderHook(() => useDragAndDropLanguagesHook(mockLanguages));

    // Verificamos que el índice inicial es null
    expect(result.current.draggedItemIndex).toBeNull();
  });

  it("A method is expected to control the drag and cancel the default action of an event", () => {

    const { result } = renderHook(() => useDragAndDropLanguagesHook(mockLanguages))

    const preventDefault = vi.fn();
    const mockEvent = { preventDefault } as unknown as React.DragEvent<HTMLDivElement>;

    result.current.handleDragOver(mockEvent);

    expect(preventDefault).toHaveBeenCalled();

  })

})