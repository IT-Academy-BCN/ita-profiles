/* eslint-disable react-hooks/exhaustive-deps */
import { useCallback, useState } from "react";
import { TLanguage } from "../interfaces/interfaces";
import { useUpdateLanguageHook } from "./useUpdateLanguageHook";

export const useDragAndDropLanguagesHook = (langs: TLanguage[]) => {

  const { languages, reorderLanguages } = useUpdateLanguageHook(langs);
  const [draggedItemIndex, setDraggedItemIndex] = useState<number | null>(null);
  // Función para manejar el inicio del drag
  const handleDragStart = useCallback((index: number) => {
    setDraggedItemIndex(index);
  }, []);

  // Función para manejar el drag over (necesario para permitir el drop)
  const handleDragOver = useCallback((e: React.DragEvent<HTMLDivElement>) => {
    e.preventDefault();
  }, []);

  // Función para manejar el drop y reordenar la lista
  const handleDrop = useCallback((index: number) => {
    if (draggedItemIndex === null) return;

    const updatedLanguages = [...languages];
    const [draggedItem] = updatedLanguages.splice(draggedItemIndex, 1);
    updatedLanguages.splice(index, 0, draggedItem);

    reorderLanguages(updatedLanguages);
    setDraggedItemIndex(null);
  }, []);

  const values = {
    languages,
    draggedItemIndex,
    handleDragStart,
    handleDragOver,
    handleDrop
  }
  return values
}