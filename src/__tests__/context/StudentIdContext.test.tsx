import { renderHook } from '@testing-library/react'
import { describe, expect, it } from 'vitest'
import { TChildrenProps } from '../../interfaces/interfaces'
import {
  SelectedStudentProvider,
  useStudentIdContext,
} from '../../context/StudentIdContext'

describe('SelectedStudentProvider', () => {
  it('should render children', () => {
    const wrapper = ({ children }: TChildrenProps) => (
      <SelectedStudentProvider>{children}</SelectedStudentProvider>
    )
    const { result } = renderHook(() => useStudentIdContext(), { wrapper })
    expect(result.current.studentUUID).toBeDefined()
  })
  it('should throw an error', async () => {
    renderHook(() => {
      try {
        useStudentIdContext()
      } catch (error: unknown) {
        if (error instanceof Error) {
          expect(`${error.message}`).toEqual(
            'useStudentIdContext has to be used inside a SelectedStudentProvider',
          )
        }
      }
    })
  })
})
