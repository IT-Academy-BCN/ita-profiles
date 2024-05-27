import { expect, afterEach, beforeAll } from 'vitest'
import { cleanup } from '@testing-library/react'
import matchers from '@testing-library/jest-dom/matchers'
import MockAdapter from 'axios-mock-adapter'
import axios from 'axios'
// extends Vitest's expect method with methods from react-testing-library
expect.extend(matchers)
export const configureMockAdapter = () => {
  const mock = new MockAdapter(axios, { onNoMatch: 'throwException' })
  beforeAll(() => {
    // console.log('this is the mock declaration', mock)
    mock.reset()
  })
  afterEach(() => {
    cleanup()
  })
  return mock
}
