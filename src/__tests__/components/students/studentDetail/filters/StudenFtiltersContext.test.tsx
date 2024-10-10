import { renderHook, act } from '@testing-library/react'
import { describe, expect, it } from 'vitest'
import { ReactNode, useContext } from 'react'
import {
    StudentFiltersContext,
    StudentFiltersProvider,
} from '../../../../../context/StudentFiltersContext'

describe('StudentFiltersProvider', () => {
    it('should add role to selectedRoles', () => {
        const wrapper = (
            { children }: { children: ReactNode }, // Explicitly type children prop
        ) => <StudentFiltersProvider>{children}</StudentFiltersProvider>

        const { result } = renderHook(() => useContext(StudentFiltersContext), {
            wrapper,
        })

        act(() => {
            result.current?.addRole('Role1') // Guard against result.current being undefined
        })

        expect(result.current?.selectedRoles).toEqual(['Role1']) // Guard against result.current being undefined
    })

    it('should remove role from selectedRoles', () => {
        const wrapper = (
            { children }: { children: ReactNode }, // Explicitly type children prop
        ) => <StudentFiltersProvider>{children}</StudentFiltersProvider>

        const { result } = renderHook(() => useContext(StudentFiltersContext), {
            wrapper,
        })

        act(() => {
            result.current?.addRole('Role1') // Guard against result.current being undefined
            result.current?.addRole('Role2') // Guard against result.current being undefined
            result.current?.removeRole('Role1') // Guard against result.current being undefined
        })

        expect(result.current?.selectedRoles).toEqual(['Role2']) // Guard against result.current being undefined
    })
})
