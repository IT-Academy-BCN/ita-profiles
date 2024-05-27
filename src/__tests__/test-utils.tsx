import React, { ReactElement } from 'react'
import { render, RenderOptions } from '@testing-library/react'
import { I18nextProvider } from 'react-i18next'
import i18n from '../locales/i18n'

const AllTheProviders = ({ children }: { children: React.ReactNode }) => (
  <I18nextProvider i18n={i18n}>{children}</I18nextProvider>
)

const customRender = (
  ui: ReactElement,
  options?: Omit<RenderOptions, 'wrapper'> & { initialEntries?: string[] },
) => {
  const { initialEntries, ...restOptions } = options ?? {}
  return render(ui, {
    wrapper: (props) => <AllTheProviders {...props} />,
    ...restOptions,
  })
}

export * from '@testing-library/react'
export { customRender as render }
