import i18n from 'i18next'
import { initReactI18next } from 'react-i18next'
import LanguageDetector from 'i18next-browser-languagedetector'
import HttpBackend, { HttpBackendOptions } from 'i18next-http-backend'
import { supportedLngs } from '../lib/data/supportedLngs'
import { localPath } from '../lib/const/endpoints'

i18n
  .use(initReactI18next)
  .use(LanguageDetector)
  .use(HttpBackend)
  .init<HttpBackendOptions>({
    supportedLngs,
    fallbackLng: 'ca',
    detection: {
      order: [
        'htmlTag',
        'cookie',
        'navigator',
        'localStorage',
        'path',
        'subdomain',
      ],
      caches: ['cookie'],
    },
    backend: {
      loadPath: localPath,
    },
    interpolation: { escapeValue: false },
  })

export default i18n
