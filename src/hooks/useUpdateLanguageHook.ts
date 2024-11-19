import { useState } from 'react';

import languagesJson from "../locales/languages/languages.json"
import { TAvailableLanguage, TLanguage, UpdateLanguageNotification } from '../interfaces/interfaces';


export const useUpdateLanguageHook = (studentLanguages: TLanguage[]) => {


  const { countries } = languagesJson
  const [availableLanguages] = useState<TAvailableLanguage[]>(countries)
  const [updateLanguages, setUpdateLanguages] = useState<TLanguage[]>(structuredClone(studentLanguages));
  const [notification, setNotification] = useState<UpdateLanguageNotification | null>(null);


  const sendNotification = (msg: string | null) => {
    setNotification({
      message: msg
    })
  }
  // Agrega un nuevo idioma a la lista
  const addLanguage = (newLanguage: TLanguage) => {
    setUpdateLanguages((prevLanguages) => [...prevLanguages, newLanguage]);

  };

  // Elimina un idioma existente por ID
  const deleteLanguage = (languageId: string) => {
    setUpdateLanguages((prevLanguages) =>
      prevLanguages.filter((lang) => lang.id !== languageId)
    );

  };

  // Edita un idioma existente por ID
  const editLanguage = (updatedLanguage: TLanguage) => {
    setUpdateLanguages((prevLanguages) =>
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
    setUpdateLanguages(orderedLanguages);

  };

  return {
    updateLanguages,
    notification,
    availableLanguages,
    addLanguage,
    deleteLanguage,
    editLanguage,
    reorderLanguages,
    sendNotification
  };
}
