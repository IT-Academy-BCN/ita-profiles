import { expect, afterEach, beforeAll } from 'vitest'
import { cleanup } from '@testing-library/react'
import matchers from '@testing-library/jest-dom/matchers'
import MockAdapter from 'axios-mock-adapter'
import axios from 'axios'

expect.extend(matchers)
export const configureMockAdapter = () => {
    const mock = new MockAdapter(axios, { onNoMatch: 'throwException' })
    beforeAll(() => {
        mock.reset()
    })
    afterEach(() => {
        cleanup()
        mock.reset()
    })
    return mock
}
