import { useState } from 'react';
import languagesJson from "../locales/languages/languages.json"
import { TAvailableLanguage, TLanguage } from '../../types';

export const useUpdateLanguageHook = (studentLanguages: TLanguage[]) => {

  const { countries } = languagesJson
  const [availableLanguages] = useState<TAvailableLanguage[]>(countries)
  const [updateLanguages, setUpdateLanguages] = useState<TLanguage[]>(structuredClone(studentLanguages));


  const addLanguage = (newLanguage: TLanguage) => {
    setUpdateLanguages((prevLanguages) => [...prevLanguages, newLanguage]);

  };

  const deleteLanguage = (languageId: string) => {
    setUpdateLanguages((prevLanguages) =>
      prevLanguages.filter((lang) => lang.id !== languageId)
    );

  };

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

  const reorderLanguages = (orderedLanguages: TLanguage[]) => {
    setUpdateLanguages(orderedLanguages);

  };

  return {
    updateLanguages,
    availableLanguages,
    addLanguage,
    deleteLanguage,
    editLanguage,
    reorderLanguages
    reorderLanguages
  };
}
