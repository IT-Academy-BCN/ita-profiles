import { createContext, useContext, useMemo, useState } from 'react'
import { TchildrenProps } from '../interfaces/interfaces'

type TSelectedStudentContext = {
  // this can be null bc when the page loads, no student is selected.
  studentUUID: string | null
  setStudentUUID: (id: string | null) => void
}
// this context receives a state as argument:
// studentUUID which is the one that will store the uuid
// setStudentUUID which is the function that will get us the uuid
export const SelectedStudentIdContext = createContext<TSelectedStudentContext>({
  studentUUID: null,
  setStudentUUID: () => { },
})
// The provider ===>
export const SelectedStudentProvider = ({ children }: TchildrenProps) => {
  const [studentUUID, setStudentUUID] = useState<string | null>(null)

  const contextValue = useMemo(
    () => ({ studentUUID, setStudentUUID }),
    [studentUUID],
  )

  return (
    <SelectedStudentIdContext.Provider value={contextValue}>
      {children}
    </SelectedStudentIdContext.Provider>
  )
}

// hook to use context
export const useStudentIdContext = () => {
  const context = useContext(SelectedStudentIdContext)
  if (!context) {
    throw new Error(
      'SelectedStudentIdContext has to be used inside a SelectedStudentProvider',
    )
  }
  return context
}
