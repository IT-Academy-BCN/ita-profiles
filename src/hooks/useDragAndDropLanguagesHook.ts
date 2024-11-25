/* eslint-disable react-hooks/exhaustive-deps */
import { useCallback, useState } from "react";
import { TLanguage } from "../interfaces/interfaces";
import { useUpdateLanguageHook } from "./useUpdateLanguageHook";

export const useDragAndDropLanguagesHook = (updateLanguagesDrop: TLanguage[]) => {

  const { reorderLanguages } = useUpdateLanguageHook(updateLanguagesDrop);
  const [draggedItemIndex, setDraggedItemIndex] = useState<number | null>(null);
  // Función para manejar el inicio del drag
  const handleDragStart = useCallback((index: number) => {
    setDraggedItemIndex(index);
  }, []);

  const handleDragOver = useCallback((e: React.DragEvent<HTMLDivElement>) => {
    e.preventDefault();
  }, []);

  const handleDrop = useCallback((index: number) => {
    if (draggedItemIndex === null) return;

    const updatedLanguages = [...updateLanguagesDrop];
    const [draggedItem] = updatedLanguages.splice(draggedItemIndex, 1);
    updatedLanguages.splice(index, 0, draggedItem);

    reorderLanguages(updatedLanguages);
    setDraggedItemIndex(null);
  }, []);

  const values = {
    updateLanguagesDrop,
    draggedItemIndex,
    handleDragStart,
    handleDragOver,
    handleDrop
  }
  return values
}
