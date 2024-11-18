import { useState } from 'react';
import languagesJson from "../locales/languages/languages.json"
import { TAvailableLanguage, TLanguage, UpdateLanguageNotification } from '../interfaces/interfaces';

export const useUpdateLanguageHook = (studentLanguages: TLanguage[]) => {

  const { countries } = languagesJson
  const [availableLanguages] = useState<TAvailableLanguage[]>(countries)
  const [languages, setLanguages] = useState<TLanguage[]>(structuredClone(studentLanguages));
  const [notification, setNotification] = useState<UpdateLanguageNotification | null>(null);

  // Agrega un nuevo idioma a la lista
  const addLanguage = (newLanguage: TLanguage) => {
    setLanguages((prevLanguages) => [...prevLanguages, newLanguage]);
  };

  // Elimina un idioma existente por ID
  const deleteLanguage = (languageId: string) => {
    setLanguages((prevLanguages) =>
      prevLanguages.filter((lang) => lang.id !== languageId)
    );
  };

  // Edita un idioma existente por ID
  const editLanguage = (updatedLanguage: TLanguage) => {
    setLanguages((prevLanguages) =>
      prevLanguages.map((lang) => {
        if (lang.id === updatedLanguage.id) {
          lang = {
            ...updatedLanguage,
          }
        }
        return lang;
      }
      )
    );
  };

  // Reordena la lista de idiomas
  const reorderLanguages = (orderedLanguages: TLanguage[]) => {
    setLanguages(orderedLanguages);
  };

  // Guarda los cambios y envía los datos
  const saveChanges = (studentId: string, updatedLanguages: TLanguage[]) => {
    if (studentId !== '69009fad-7863-425c-9049-df62033e2f82') {
      setNotification({ message: 'Estudiant o idioma no trobat' });
      return;
    }
    try {
      // Simulación de actualización de datos
      setLanguages(updatedLanguages);
      setNotification({ message: 'Idioma actualitzat correctament' });
    } catch (error) {
      setNotification({
        message: `S'ha produït un error mentre s'actualitzava l'idioma`,
      });
    }
  };

  return {
    languages,
    notification,
    availableLanguages,
    addLanguage,
    deleteLanguage,
    editLanguage,
    reorderLanguages,
    saveChanges,
  };
}
