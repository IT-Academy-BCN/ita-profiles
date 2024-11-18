import { renderHook, act } from '@testing-library/react';
import { describe, expect, it } from 'vitest';
import { useUpdateLanguageHook } from '../../hooks/useUpdateLanguageHook';
import languagesJson from "../../locales/languages/languages.json"

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

describe('useUpdateLanguageHook', () => {

  it('should be defined', () => {
    expect(useUpdateLanguageHook).toBeDefined();
  });

  it('should return initial studentLanguages', () => {
    const { result } = renderHook(() => useUpdateLanguageHook(mockLanguages));

    expect(result.current.languages).toEqual(mockLanguages);
  });

  it('should return initial availableLanguages', () => {
    const { result } = renderHook(() => useUpdateLanguageHook(mockLanguages));

    expect(result.current.availableLanguages).toEqual(languagesJson.countries);
  });

  it('should store a new language when addLanguage is called', () => {
    const { result } = renderHook(() => useUpdateLanguageHook(mockLanguages));

    act(() => {
      result.current.addLanguage({
        id: 'newLanguageId',
        name: 'Gallego',
        level: 'Nivell avançat',
      });
    });

    expect(result.current.languages).toEqual([
      ...mockLanguages,
      {
        id: 'newLanguageId',
        name: 'Gallego',
        level: 'Nivell avançat',
      },
    ]);
  });

  it('should remove a language when deleteLanguage is called', () => {
    const { result } = renderHook(() => useUpdateLanguageHook(mockLanguages));
    const languageId = '69009fad-7863-425c-9049-df62033e2f82';

    act(() => {
      result.current.deleteLanguage(languageId);
    });

    expect(result.current.languages).toEqual(
      mockLanguages.filter((lang) => lang.id !== languageId)
    );
  });

  it('should edit a language when editLanguage is called', () => {
    const { result } = renderHook(() => useUpdateLanguageHook(mockLanguages));
    const languageIdMock = 'd108e5aa-e058-4245-8a9a-e056a1594dfa';

    act(() => {
      result.current.editLanguage({
        id: languageIdMock,
        name: 'Castellà',
        level: 'Nivell avançat',
      });
    });

    expect(result.current.languages).toEqual([
      {
        id: languageIdMock,
        name: 'Castellà',
        level: 'Nivell avançat',
      },
      ...mockLanguages.slice(1),
    ]);
  });

  it("should reorder languages", () => {

    const { result } = renderHook(() =>
      useUpdateLanguageHook(mockLanguages)
    );

    act(() => {
      result.current.reorderLanguages([
        {
          id: "d108e5aa-e058-4245-8a9a-e056a1594dfg",
          name: "Anglais",
          level: "Avançat",
        },
        {
          id: "d108e5aa-e058-4245-8a9a-e056a1594dfa",
          name: "Francès",
          level: "Intermedi"
        }

      ]);
    });

    expect(result.current.languages).toEqual([
      {
        id: "d108e5aa-e058-4245-8a9a-e056a1594dfg",
        name: "Anglais",
        level: "Avançat",
      },
      {
        id: "d108e5aa-e058-4245-8a9a-e056a1594dfa",
        name: "Francès",
        level: "Intermedi"
      }
    ]);
  });

  it('should save changes and return a success message', () => {
    const { result } = renderHook(() => useUpdateLanguageHook(mockLanguages));
    const studentIdMock = '69009fad-7863-425c-9049-df62033e2f82';

    act(() => {
      result.current.saveChanges(studentIdMock, [
        {
          id: '9137a959-f801-4744-bc82-1427f25e05cd',
          name: 'Anglès',
          level: 'Basic',
        },
        {
          id: '69009fad-7863-425c-9049-df62033e2f82',
          name: 'Castellà',
          level: 'Intermedi',
        },
      ]);
    });

    expect(result.current.notification).toEqual({
      message: 'Idioma actualitzat correctament',
    });
  });

  it('should handle errors in saveChanges when invalid studentId is provided', () => {
    const { result } = renderHook(() => useUpdateLanguageHook(mockLanguages));
    const invalidStudentId = 'invalid-id';

    act(() => {
      result.current.saveChanges(invalidStudentId, []);
    });

    expect(result.current.notification).toEqual({
      message: 'Estudiant o idioma no trobat',
    });
  });
});