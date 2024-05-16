import { ReactNode } from 'react'

export interface ILoginForm {
  // this must be changed to 'dni' instead of 'email' but for json-server we need it to be 'email'
  email: string
  password: string
}

// This could be used globally if we're passing just the children props.
// Good for providers
export type TchildrenProps = {
  children: ReactNode
}

// === SmallScreenContext ===
export type TSmallScreenContext = {
  isMobile: boolean
  setIsMobile: React.Dispatch<React.SetStateAction<boolean>>
}

// === studentList ===
export interface IStudentList {
  id: string
  fullname: string
  subtitle: string
  photo: string
  tags: ITag[]
}

export interface ITag {
  id: number
  name: string
}

export type TLanguage = {
  language_id: string
  language_name: string
  language_level: string
}
