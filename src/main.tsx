import React from 'react'
import ReactDOM from 'react-dom/client'
import { I18nextProvider } from 'react-i18next'
import { Provider } from 'react-redux'
import { SelectedStudentProvider } from './context/StudentIdContext'
import App from './App'
import i18n from './locales/i18n'
import { store } from './store/store'
import { LoginProvider } from './context/LoginContext'

import './styles/index.css'
import './styles/normalize.css'

ReactDOM.createRoot(document.getElementById('root')!).render(
  <React.StrictMode>
    <Provider store={store}>
      <I18nextProvider i18n={i18n}>
        <SelectedStudentProvider>
          <LoginProvider>
            <App />
          </LoginProvider>
        </SelectedStudentProvider>
      </I18nextProvider>
    </Provider>
  </React.StrictMode>,
)
