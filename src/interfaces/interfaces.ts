import { ReactNode } from 'react'

export interface ILoginForm {
  // this must be changed to 'dni' instead of 'email' but for json-server we need it to be 'email'
  dni: string
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

export type TBootcamp = {
  bootcamp_id: string
  bootcamp_name: string
  bootcamp_end_date: string
}

export type TModality = {
  modality: string[]
}

export type TProject = {
  uuid: number
  project_name: string
  company_name: string
  tags: ITag[]
  project_url: string
  github_url: string
}

export type TLanguage = {
  language_id: string
  language_name: string
  language_level: string
}

export type TAbout = {
  id: number
  fullname: string
  subtitle: string
  social_media: {
    github: {
      url: string
    }
    linkedin: {
      url: string
    }
  }
  about: string
  photo: string
  tags: ITag[]
}

export type TAdditionalTraining = {
  uuid: string
  course_name: string
  study_center: string
  course_beginning_year: number
  course_ending_year: number
  duration_hrs: number
}

export type TCollaboration = {
  uuid: string
  collaboration_name: string
  collaboration_description: string
  collaboration_quantity: number
}